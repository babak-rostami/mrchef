<div id="bcomment-like-btn-{{ $comment->id }}" data-loading="false"
    class="rounded-2xl bg-blue-100 flex gap-1 w-fit px-3 py-0.5 border border-blue-200 cursor-pointer"
    onclick="reactTobComment('{{ $comment->id }}','like')">
    <span id="bcomment-like-count-{{ $comment->id }}">
        {{ $comment->like_count }}
    </span>
    <img class="w-6" src="{{ asset('files/icon/like-finger.svg') }}">
</div>

<div id="bcomment-dislike-btn-{{ $comment->id }}" data-loading="false"
    class="rounded-2xl bg-red-100 flex gap-1 w-fit px-3 py-0.5 border border-red-200 cursor-pointer"
    onclick="reactTobComment('{{ $comment->id }}','dislike')">
    <span id="bcomment-dislike-count-{{ $comment->id }}">
        {{ $comment->dislike_count }}
    </span>
    <img class="w-6" src="{{ asset('files/icon/dislike-finger.svg') }}">
</div>
