<x-layouts::auth :title="__('Register')">

    {{-- この場所にstyleを書くのはあまりよくないが、ログイン画面と新規登録画面で背景画像を分けるためにこちらに記載 --}}
    <style>
        @media (min-width: 640px) {
            .bg-auth {
                background-image: url('{{ asset('logo/background.png') }}') !important;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
        }
    </style>

    <div class="flex flex-col gap-6">
    <a href="{{ route('home') }}">
        <img src="{{ asset('logo/logo.png') }}" class="w-auto ms-1" alt="Pebble">
    </a>
    <div class="bg-zinc-200 rounded-lg border bg-card text-card-foreground shadow-sm mx-auto w-full max-w-md">
    <div class="flex flex-col space-y-1.5 p-6 items-center">

        <x-auth-header :title="__('Create an account')" :description="__('')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <flux:input
                name="name"
                :label="__('Name')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Avatar -->
            <flux:input
                :label="__('Avatar')"
                id="avatar"
                name="avatar"
                type="file"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>
    </div>
    </div>
</x-layouts::auth>
