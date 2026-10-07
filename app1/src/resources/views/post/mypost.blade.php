<x-layouts::app>

{{-- モバイル専用ヘッター --}}
<div class="fixed top-0 left-0 w-full border-b md:hidden z-50" style="background-color: rgba(244, 244, 245, 0.8);">
    <div class="flex justify-around items-center py-1">
    <p class="flex flex-col items-center">
        <img src="{{ asset('logo/logo.png') }}" alt="Pebble" class="h-12 w-auto">
    </p>
    </div>
</div>
    <br>
    {{-- 投稿一覧表示用のコード --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <flux:main container>
        <flux:heading size="xl" level="1">あなたのアルバム</flux:heading>
        <flux:text class="mt-2 mb-6 text-base">ここをあなたの思い出でいっぱいにしましょう！</flux:text>
        <flux:separator variant="subtle" />
        <x-message :message="session('message')" type="success" />
        @if (count($posts) == 0)
        <p class="mt-4">
            まだ何も投稿していません
        </p>
        @else
        <br>
        @foreach ($posts as $post)
        <flux>
            <div>
                <div class="mt-4">
                    <div
                        class="bg-zinc-50 w-full  rounded-2xl p-2 shadow-lg hover:shadow-2xl transition duration-500">
                        <div class="mt-4">
                            <h1
                                class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer float-left p-3">
                                <a href="{{ route('post.show', $post) }}">{{ $post->title }}</a>
                            </h1>
                            {{-- <hr class="w-full"> --}}
                            {{-- <p class="text-gray-600 mx-4 pb-4 pt-3">{{$post->body}}</p> --}}
                            <br><br>
                            @if ($post->image)
                                <img src="{{ asset('storage/images/' . $post->image) }}" class="rounded mx-auto" style="height:100%; width: 100%; border: 0.01px solid #d8d8d8;">
                            @endif
                            <div class="text-sm font-semibold flex flex-row-reverse pt-3">
                                <p>
                                    {{ optional($post->user)->name ?? '削除されたユーザー' }}さん
                                    /
                                    {{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </flux>
        @endforeach
        @endif
    </div>
  </flux:main>
 <br>
</x-layouts::app>

{{-- モバイル専用フッター --}}
<div class="fixed bottom-0 left-0 w-full bg-zinc-100 border-t border-b md:hidden">
    <div class="flex justify-around items-center py-2">

        {{-- ログアウト --}}
        <form method="POST" action="{{ route('logout') }}" class="flex flex-col items-center" style="color: #888888;">
            @csrf
            <button type="submit">
                <flux:icon name="arrow-left-start-on-rectangle" class="w-6 h-6" />
            </button>
        </form>

        {{-- 投稿一覧 --}}
        <a href="{{ route('post.index') }}" class="flex flex-col items-center" style="color: #888888;">
            <flux:icon name="magnifying-glass" class="w-6 h-6" />
        </a>

        {{-- 新規投稿 --}}
        <a href="{{ route('post.create') }}" class="flex flex-col items-center" style="color: #888888;">
            <flux:icon name="plus" class="w-6 h-6" />
        </a>

        {{-- 設定 --}}
        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center" style="color: #888888;">
            <flux:icon name="cog-6-tooth" class="w-6 h-6" />
        </a>

    </div>
</div>
