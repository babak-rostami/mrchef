@props(['comment'])

<div class="like-icon rounded-2xl bg-blue-100 flex gap-1 w-fit
                                                            px-3 py-0.5 border border-blue-200
                                                            hover:scale-105 duration-300 cursor-pointer"
    onclick="likeCategoryComment('{{$comment->id}}')">
    <span class="font-medium" id="category-comment-like-count-{{$comment->id}}">0</span>
    <img alt="like icon" class="like-com-image w-6" loading="lazy" id="like-com-image-{{$comment->id}}"
        src="{{asset('files/icon/like-finger.svg')}}">
</div>