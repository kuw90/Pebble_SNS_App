<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen {{ auth()->user()->can('admin') ? 'bg-zinc-50' : 'bg-white' }} dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 {{ auth()->user()->can('admin') ? 'bg-neutral-900' : 'bg-zinc-50'}}">
            <flux:sidebar.header>
                {{-- <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate /> --}}
                <p class="p-2 w-full flex justify-center">
                    {{-- 管理者の場合 --}}
                    @can('admin')
                        <img src="{{ asset('logo/logo2.png') }}" alt="Pebble" class="h-12 w-auto">
                    @else
                        <img src="{{ asset('logo/logo.png') }}" alt="Pebble" class="h-12 w-auto">
                    @endcan
                </p>
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                {{-- <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                </flux:sidebar.group> --}}

                {{-- 追加 --}}
                <flux:sidebar.group class="grid">
                    <hr class="w-full">
                    <br>
                    {{-- 管理者の場合 --}}
                    @can('admin')
                        <flux:sidebar.item icon="user" :href="route('admin.users')"
                            :current="request() -> routeIs('admin.users')" wire:navigate>ユーザー管理</flux:sidebar.item>
                        <br>
                        <flux:sidebar.item icon="magnifying-glass" :href="route('admin.posts')"
                            :current="request() -> routeIs('admin.posts')" wire:navigate>ユーザー投稿</flux:sidebar.item>
                        <br>
                    {{-- 一般ユーザーの場合 --}}
                    @else
                        <flux:sidebar.item icon="magnifying-glass" :href="route('post.index')"
                            :current="request() -> routeIs('post.index')" wire:navigate>ストーリーズ</flux:sidebar.item>
                        <br>
                        <flux:sidebar.item icon="plus" :href="route('post.create')" :current="request() -> routeIs('post.create')"
                            wire:navigate>新規作成</flux:sidebar.item>
                        <br>
                        <flux:sidebar.item icon="bookmark-square" :href="route('post.mypost')"
                            :current="request() -> routeIs('post.mypost')" wire:navigate>マイアルバム</flux:sidebar.item>
                    @endcan
                </flux:sidebar.group>
                {{-- 追加終わり --}}
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                {{-- <flux:sidebar.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item> --}}

                {{-- <flux:sidebar.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:sidebar.item> --}}
            </flux:sidebar.nav>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                {{-- <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                /> --}}

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                {{-- <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                /> --}}

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
