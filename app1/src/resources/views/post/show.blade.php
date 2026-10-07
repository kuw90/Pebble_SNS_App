<x-layouts::app>

    <div class="max-w-7xl mx-auto px-0 sm:px-6 lg:px-8">
      <flux:main container>
        <div class="mx-0 sm:p-8">
            <div class="px-2 sm:px-10 mt-4">
                <flux:separator variant="subtle" />
                <x-message :message="session('message')" type="success" />
                <flux>
                <div class="bg-zinc-50 w-full rounded-2xl px-4 sm:px-10 py-8 shadow-lg hover:shadow-2xl transition duration-500">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex">
                            <p class="text-lg text-gray-700 font-semibold ml-2">
                                {{ $post->title }}
                            </p>
                        </div>
                        <div class="flex justify-end my-2">
                                @can('post-owner', $post)
                                <a href="{{ route('post.edit', $post) }}">
                                    <flux:button class="bg-teal-700 float-right" style="padding: 2px 10px; font-size: 12px;">編集</flux:button>
                                </a>
                                @endcan
                                @canany(['post-owner', 'admin'], $post)
                                <form method="post" action="{{ route('post.destroy', $post) }}">
                                    @csrf
                                    @method('delete')
                                    <flux:button variant="danger" style="padding: 2px 10px; font-size: 12px;" class="bg-red-700 float-right ml-4" type="submit"
                                        onClick="return confirm('本当に削除しますか？');">削除</flux:button>
                                </form>
                                @endcanany                                
                        </div>
                    </div>
                    <hr class="w-full">
                    <p class="text-gray-600 mx-4 pb-4 pt-3">{{ $post->body }}</p>
                    @if ($post->image)
                        <img src="{{ asset('storage/images/' . $post->image) }}" class="rounded mx-auto" style="height:100%; width: 100%; border: 0.01px solid #d8d8d8;">
                    @endif
                    <br>
                    {{-- いいねボタン・アバター表示 --}}
                    <div class="flex items-center">

                        {{-- いいねボタン --}}
                        @can('admin')
                            {{-- 管理者の場合は非表示 --}}
                        @else
                            @auth
                            <!-- その投稿がいいねしているか判定 -->
                            @if (Auth::user()->likes()->where('post_id', $post->id)->exists())
                            <ion-icon name="heart" class="like-btn cursor-pointer text-pink-500" id={{$post->id}}></ion-icon>
                            @else
                            <ion-icon name="heart-outline" class="like-btn cursor-pointer" id={{$post->id}}></ion-icon>
                            @endif
                            <p class="count-num">{{$post->likes->count()}}</p>
                            @endauth
                        @endcan

                        {{-- アバター表示 --}}
                        <p class="ml-auto">
                         <div class="flex">
                            <p class="text-gray-600 mx-2 pb-4 pt-3">{{ optional($post->user)->name ?? '削除されたユーザー' }}</p>
                            <img src="{{ asset('storage/avatar/' . ($post->user->avatar)) }}" class="rounded-lg h-12 w-14">
                         </div>
                        </p>
                    </div>
                    {{-- いいねボタン・アバター表示ここまで --}}
                    <br>
                    {{-- 投稿日 --}}
                    <p class="flex justify-end">
                        {{ $post->created_at->diffForHumans() }}
                        に投稿されました
                    </p>

                    {{-- 追加部分 --}}
                    <div class="mt-4 mb-12">
                        @can('admin')
                            {{-- 管理者の場合は非表示 --}}
                        @else
                            <form method="post" action="{{route('comment.store')}}">
                                @csrf
                                <input type="hidden" name='post_id' value="{{$post->id}}">
                                <textarea name="body" class="bg-white w-full  rounded-2xl px-4 mt-4 py-4 shadow-lg hover:shadow-2xl transition duration-500" id="body" cols="30" rows="3" placeholder="コメントを追加（※投稿後は削除できませんので、ご注意ください）">{{old('body')}}</textarea>
                                <flux:button type="submit" class="float-right mr-4 mb-12">コメントする</flux:button>
                            </form>
                        @endcan
                    </div>
                    {{-- コメント投稿フォーム・ボタンここまで --}}
                    <br>
                    {{-- ここからコメント表示 --}}
                    @foreach ($post->comments as $comment)
                    <div class="bg-white w-full  rounded-2xl px-4 sm:px-10 py-2 shadow-lg mt-8 whitespace-pre-line">
                        {{$comment->body}}
                        <div class="text-sm font-semibold flex items-center justify-end">
                            {{-- アバター追加 --}}
                            <span class="rounded-lg w-14 h-12">
                                <img src="{{ asset('storage/avatar/' . ($comment->user->avatar)) }}" class="w-full h-full rounded-lg">
                            </span>
                            <p class="pt-4 text-right">
                                &nbsp;&nbsp;{{ $comment->created_at->diffForHumans() }}・{{ $comment->user->name }} 
                            </p>
                        </div>
                    </div>
                    @endforeach
                    {{-- 追加部分終わり --}}
                </div>
                </flux>
            </div>
        </div>
      </flux:main>
    </div>
</x-layouts::app>

{{-- 戻るボタン --}}
<div class="fixed top-0 left-0 w-full border-b md:hidden z-50" style="background-color: rgba(244, 244, 245, 0.8);">
    <div class="flex justify-start items-center py-2 pl-3">

        <a href="{{ route('post.index') }}" class="flex items-center gap-1">
        &nbsp;&nbsp;<flux:icon name="arrow-left" class="w-4 h-4" />
            <span class="text-sm">ポスト</span>
        </a>

    </div>
</div>
