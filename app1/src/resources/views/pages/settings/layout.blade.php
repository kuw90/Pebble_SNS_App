<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist aria-label="{{ __('Settings') }}">
            <flux:navlist.item :href="route('profile.edit')" wire:navigate>{{ __('Profile') }}</flux:navlist.item>
            <flux:navlist.item :href="route('security.edit')" wire:navigate>{{ __('Security') }}</flux:navlist.item>
            {{-- <flux:navlist.item :href="route('appearance.edit')" wire:navigate>{{ __('Appearance') }}</flux:navlist.item> --}}
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>

{{-- 戻るボタン --}}
<div class="fixed top-0 left-0 w-full border-b md:hidden z-50" style="background-color: rgba(244, 244, 245, 0.8);">
    <div class="flex justify-start items-center py-2 pl-3">

        <a href="{{ route('post.index') }}" class="flex items-center gap-1">
        &nbsp;&nbsp;<flux:icon name="arrow-left" class="w-4 h-4" />
            {{-- <span class="text-sm">ストーリーズ</span> --}}
        </a>

    </div>
</div>