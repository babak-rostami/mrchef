@props(['comment'])

<div id="comment-box-{{ $comment->id }}"
    class="bcomment-item px-3 pb-3 pt-2 rounded-2xl mt-4 border border-gray-200 {{ $comment->isReply() ? 'bg-gray-50' : '' }}">

    {{-- پروفایل و زمان کامنت --}}
    <div class="flex items-center justify-between w-full">
        <x-comment.item.user :user="$comment->user" />
        <span class="text-gray-500 text-[11px]">{{ $comment->created_at }}</span>
    </div>

    {{-- وقتی این یه پاسخ به یه پاسخِ دیگه‌ست (نه مستقیم به کامنت اصلی)، مشخص می‌کنیم به کی جواب داده شده --}}
    @if ($comment->reply_id && $comment->replyTo)
        <div class="mr-2 mt-2 text-sm text-blue-700">
            پاسخ به <span class="font-bold">{{ $comment->replyTo->user->name }}</span>
        </div>
    @endif

    {{-- متن کامنت --}}
    <p class="ml-2 mt-4 text-[20px] whitespace-pre-line">{{ $comment->body }}</p>

    {{-- اکشن های کامنت --}}
    <div class="flex gap-2 mt-8 mb-2">
        <x-comment.item.action.reaction :comment="$comment" />
        <x-comment.item.action.reply :comment="$comment" />
    </div>

    <x-comment.item.replies-toggle :comment="$comment" />

</div>