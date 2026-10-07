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
    {{-- ユーザー管理画面のコード --}}
    <div class="p-6">
        <div class="overflow-x-auto">
            <x-message :message="session('message')" type="success" />
            <br>
            {{-- PC表示 --}}
            <div class="hidden lg:block">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">画像</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">名前</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">メールアドレス</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">作成日</th>
                        {{-- 追加一行 --}}
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{asset('storage/avatar/'.($user->avatar??'user_default.jpg'))}}" class="w-10">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->created_at }}</td>
                            {{-- 追加三行 --}}
                            <td class="px-1 py-4 whitespace-nowrap">    
                            @if (!$user->roles->contains('id', 1))
                                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('本当に削除しますか？')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">削除</button>
                                </form>
                            @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            {{-- モバイル表示 --}}
            <div class="lg:hidden space-y-4">
                @foreach ($users as $user)
                    <div class="border rounded-lg p-4 bg-white">

                        <div class="flex items-center gap-3 mb-3">
                            <img src="{{ asset('storage/avatar/'.($user->avatar ?? 'user_default.jpg')) }}"
                                class="rounded-lg h-12 w-14">
                            <div>
                                <div class="font-bold">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                            </div>
                        </div>

                        <div class="text-sm">
                            <p><strong>メール:</strong> {{ $user->email }}</p>
                            <p><strong>作成日:</strong> {{ $user->created_at }}</p>
                        </div>
                        @if (!$user->roles->contains('id', 1))
                        <form method="POST"
                            action="{{ route('admin.users.delete', $user->id) }}"
                            class="mt-3"
                            onsubmit="return confirm('本当に削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">
                                アカウントを削除
                            </button>
                        </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
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

        {{-- ユーザー投稿 --}}
        <a href="{{ route('admin.posts') }}" class="flex flex-col items-center" style="color: #888888;">
            <flux:icon name="magnifying-glass" class="w-6 h-6" />
        </a>

        {{-- 設定 --}}
        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center" style="color: #888888;">
            <flux:icon name="cog-6-tooth" class="w-6 h-6" />
        </a>

    </div>
</div>
