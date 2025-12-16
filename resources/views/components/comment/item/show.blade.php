@props(['comment'])

<div id="comment-box-{{ $comment->id }}" class="px-3 pb-3 pt-2 rounded-2xl mt-4 border border-gray-200">

    {{-- پروفایل و زمان کامنت --}}
    <div class="flex items-center justify-between w-full">

        <!-- پروفایل -->
        <x-comment.item.user :user="$comment->user" />

        <!-- زمان -->
        <span class="text-gray-500 text-[11px]">{{ $comment->created_at }}</span>
    </div>

    {{-- متن کامنت --}}
    <p class="ml-2 mt-4 text-[20px] whitespace-pre-line">{{ $comment->body }}</p>

    {{-- اکشن های کامنت --}}
    <div class="flex gap-2 mt-8 mb-2">
        {{-- reaction --}}
        <x-comment.item.action.reaction :comment="$comment" />

        {{-- reply --}}
        <x-comment.item.action.reply :comment="$comment" />
    </div>

    @if ($comment->reply_count > 0)
        <button class="w-full bg-blue-100 rounded-2xl mt-4 py-2 font-medium cursor-pointer hover:bg-blue-200"
            id="show-replies-btn-{{ $comment->id }}" data-loaded="false" data-open="false" data-loading="false"
            onclick="showReplies('{{ $comment->id }}')">
            مشاهده {{ $comment->reply_count }} پاسخ به این نظر
        </button>

        <div id="replies-box-{{ $comment->id }}" class="hidden"></div>
    @endif

</div>
