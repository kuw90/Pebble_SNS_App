<?php

use App\Concerns\ProfileValidationRules;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Profile settings')] class extends Component {
    use ProfileValidationRules;
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $avatar;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            ...$this->profileRules($user->id),
            'avatar' => ['nullable', 'image', 'max:1024', 'dimensions:min_height=400,max_ratio=1.0'], /*ここでプロフィール画像の簡単な制限を設定している*/
        ]);
 
        if ($this->avatar) {
            // 現在の日付と時刻（秒まで）を取得
            $timestamp = now()->format('YmdHis');
            // 元のファイル名を取得
            $originalName = $this->avatar->getClientOriginalName();
            // 新しいファイル名を生成（タイムスタンプ + 元のファイル名）
            $filename = $timestamp . '_' . $originalName;
            // storage/app/public/avatar に保存
            $this->avatar->storeAs('avatar', $filename, 'public');
            //DBにファイル名保存
            $user->avatar = $filename;
        }

        /*$user->fill($validated);*/

        /**
         * $user->fill($validated); では、$validated の中に含まれていた avatarのTemporaryUploadedFileオブジェクトまでまとめて
         * users.avatar カラムへ代入されてしまい、/tmp/phpxxxxのような Livewire の一時ファイルパスが保存され、画像が正常に表示されなかった
         * 試行錯誤した末、fill() の対象から avatar を除外し、ファイル名を手動で代入するようにした
         */
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        Flux::toast(variant: 'success', text: __('Profile updated.'));
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Flux::toast(text: __('A new verification link has been sent to your email address.'));
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if ($this->hasUnverifiedEmail)
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                    </div>
                @endif
            </div>

            <div>
                @can('admin')
                    {{-- 管理者の場合は非表示 --}}
                @else
                <label for="avatar" class="block text-sm font-medium text-gray-800">プロフィール画像</label>
                <div class="my-2">
                    {{-- 新しく選択した画像がある場合はそのプレビューを表示 --}}
                    @if ($avatar)
                        <img src="{{ $avatar->temporaryUrl() }}" 
                            alt="Avatar Preview" 
                            class="w-50 rounded-xl">
                    {{-- 選択されていない場合は現在のアバターを表示 --}}
                    @elseif (auth()->user()->avatar)
                        <img src="{{ asset('storage/avatar/' . (auth()->user()->avatar)) }}"
                            alt="Current Avatar" 
                            class="w-50 rounded-xl">
                    @endif
                </div>


                <flux:input id="avatar" type="file" wire:model="avatar" class="mt-1 block w-full" />

                {{-- アップロード中の表示を追加 --}}
                <div wire:loading wire:target="avatar" class="text-sm text-gray-500 mt-1">
                    Please wait until the upload is complete...
                </div>

                @error('avatar')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
                @endcan
            </div>

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit" data-test="update-profile-button">
                    {{ __('Save') }}
                </flux:button>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <livewire:pages::settings.delete-user-form />
        @endif
    </x-pages::settings.layout>
</section>
