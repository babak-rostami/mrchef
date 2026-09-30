@props(['comment'])

@if ($comment->reply_count > 0)
    <button class="w-full bg-blue-100 rounded-2xl mt-4 py-2 font-medium cursor-pointer hover:bg-blue-200"
        id="show-replies-btn-{{ $comment->id }}" data-loaded="false" data-open="false" data-loading="false"
        onclick="showReplies('{{ $comment->id }}')">
        مشاهده {{ $comment->reply_count }} پاسخ به این نظر
    </button>
    <div id="replies-box-{{ $comment->id }}" class="hidden"></div>
@endif