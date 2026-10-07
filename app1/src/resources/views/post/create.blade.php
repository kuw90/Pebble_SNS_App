<x-layouts::app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                投稿の新規作成
            </h2> --}}
            {{-- メッセージ表示用 --}}
            <x-message :message="$errors->all()" type="error" />
            <x-message :message="session('message')" type="success" />
            <form method="post" action="{{route('post.store')}}" enctype="multipart/form-data">
            @csrf
                <div class="md:flex items-center mt-8">
                    <div class="w-full flex flex-col">
                        <label for="title" class="font-semibold leading-none mt-4 mb-1">Title  (7文字以下)</label>
                        <input type="text" name="title"
                            class="w-auto py-2 pl-2 placeholder-gray-500 border border-gray-300 rounded-md" id="title" placeholder="一言でいえば?" value="{{old('title')}}">
                    </div>
                </div>

                <div class="w-full flex flex-col">
                    <label for="body" class="font-semibold leading-none mt-4 mb-1">Body</label>
                    <textarea name="body" class="w-auto py-2 pl-2 placeholder-gray-500 border border-gray-300 rounded-md" id="body" cols="30" rows="10" placeholder="今日、何した？">{{old('body')}}</textarea>
                </div>
                
                <div class="w-full flex flex-col">
                    <label for="image" class="font-semibold leading-none mt-4 mb-2">Image</label>
                    <div>
                        <flux:input id="image" type="file" name="image" />
                    </div>
                </div>
                <br>                    
                <flux:button variant="primary" type="submit" class="w-full mt-10">投稿する</flux:button>
            </form>
        </div>
    </div>
</x-layouts::app>

{{-- 戻るボタン --}}
<div class="fixed top-0 left-0 w-full border-b md:hidden z-50" style="background-color: rgba(244, 244, 245, 0.8);">
    <div class="flex justify-start items-center py-2 pl-3">

        <a href="{{ route('post.index') }}" class="flex items-center gap-1">
        &nbsp;&nbsp;<flux:icon name="arrow-left" class="w-4 h-4" />
            <span class="text-sm">新規ポスト</span>
        </a>

    </div>
</div>