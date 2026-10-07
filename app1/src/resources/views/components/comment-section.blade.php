<div>
    {{-- コメント一覧 --}}
    @foreach ($post->comments as $comment)
        <div class="bg-white w-full rounded-2xl px-10 py-2 shadow-lg mt-8 whitespace-pre-line">
            {{ $comment->body }}
            <div class="text-sm font-semibold flex flex-row-reverse">
                <p>{{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}</p>
            </div>
        </div>
    @endforeach

    {{-- コメント投稿フォーム --}}
    <div class="mt-4 mb-12">
        @if (session()->has('message'))
            <div class="text-green-600 mb-4">
                {{ session('message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('comment.store') }}">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">

            <textarea name="body"
                class="bg-white w-full rounded-2xl px-4 mt-4 py-4 shadow-lg hover:shadow-2xl transition duration-500"
                cols="30" rows="3" placeholder="コメントを入力してください"></textarea>

            <flux:button type="submit" class="float-right mr-4 mb-12">
                コメントする
            </flux:button>
        </form>
    </div>
</div>
