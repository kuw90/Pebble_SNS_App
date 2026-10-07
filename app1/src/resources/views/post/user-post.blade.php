<x-layouts::app>

{{-- モバイル専用ヘッター --}}
<div class="fixed top-0 left-0 w-full border-b md:hidden z-50" style="background-color: rgba(0, 0, 0, 0.8);">
    <div class="flex justify-around items-center py-1">
    <p class="flex flex-col items-center">
        <img src="{{ asset('logo/logo2.png') }}" alt="Pebble" class="h-12 w-auto">
    </p>
    </div>
</div>
    <br>
    {{-- 投稿一覧表示用のコード --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <flux:main container>
            <br>
            <x-message :message="session('message')" type="success" />

            @if (count($posts) == 0)
                <p class="mt-4">まだ誰も投稿していません</p>
            @else
            {{-- PC表示 --}}
            <div class="hidden lg:block">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs text-gray-500">画像</th>
                            <th class="px-6 py-3 text-left text-xs text-gray-500">タイトル</th>
                            <th class="px-6 py-3 text-left text-xs text-gray-500">ユーザー</th>
                            <th class="px-6 py-3 text-left text-xs text-gray-500">作成日</th>
                            <th class="px-6 py-3 text-left text-xs text-gray-500"></th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach ($posts as $post)
                            <tr>
                                <td class="px-6 py-4">
                                    @if ($post->image)
                                        <img src="{{ asset('storage/images/' . $post->image) }}" class="w-16 h-16 object-cover rounded">
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <a href="{{ route('post.show', $post) }}" class="text-blue-600 hover:underline">
                                        {{ $post->title }}
                                    </a>
                                </td>

                                <td class="px-6 py-4">
                                    {{ optional($post->user)->name ?? '削除済みユーザー' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $post->created_at->diffForHumans() }}
                                </td>

                                <!-- 削除ボタン -->
                                <td class="px-6 py-4">
                                    <form method="POST"
                                          action="/post/{{ $post->id }}"
                                          onsubmit="return confirm('本当に削除しますか？')">
                                        @csrf
                                        @method('DELETE')

                                    <button class="text-red-600 hover:text-red-800">削除</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            {{-- モバイル表示 --}}
            <div class="lg:hidden space-y-4">
                @foreach ($posts as $post)
                    <div class="border rounded-lg p-4 bg-white">

                        @if ($post->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/images/' . $post->image) }}"
                                    class="w-full max-h-48 object-cover rounded">
                            </div>
                        @endif

                        <div class="mb-2">
                            <a href="{{ route('post.show', $post) }}"
                                class="font-bold text-blue-600 hover:underline">
                                {{ $post->title }}
                            </a>
                        </div>

                        <div class="text-sm text-gray-600 space-y-1">
                            <p>
                                <strong>ユーザー:</strong>
                                {{ optional($post->user)->name ?? '削除済みユーザー' }}
                            </p>

                            <p>
                                <strong>作成日:</strong>
                                {{ $post->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <form method="POST"
                            action="/post/{{ $post->id }}"
                            class="mt-3"
                            onsubmit="return confirm('本当に削除しますか？')">

                            @csrf
                            @method('DELETE')

                            <button class="text-red-600 hover:text-red-800">
                                削除
                            </button>
                        </form>

                    </div>
                @endforeach
            </div>
        </flux:main>
    </div>
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

        {{-- ユーザー管理 --}}
        <a href="{{ route('admin.users') }}" class="flex flex-col items-center" style="color: #888888;">
            <flux:icon name="user" class="w-6 h-6" />
        </a>

        {{-- 設定 --}}
        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center" style="color: #888888;">
            <flux:icon name="cog-6-tooth" class="w-6 h-6" />
        </a>

    </div>
</div>
