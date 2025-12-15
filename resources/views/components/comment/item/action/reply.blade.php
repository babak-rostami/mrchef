@props(['comment'])

<button class="rounded-2xl flex gap-2 w-fit px-4 py-0.5 border border-blue-100 bg-white items-center
    hover:scale-105 duration-300 cursor-pointer" onclick="replyModal('{{$comment->id}}')">
    <span class="text-[18px] text-blue-800">پاسخ</span>
    <img alt="reply icon" class="w-4 h-4" src="{{asset('files/icon/reply.png')}}">
</button>