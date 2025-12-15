@props(['comment'])

<span class="dislike-icon rounded-2xl bg-red-100 flex gap-1 w-fit
                                                            px-3 py-0.5 border border-red-200
                                                            hover:scale-105 duration-300 cursor-pointer"
    onclick="unlikeCategoryComment('{{$comment->id}}')">
    <span id="category-comment-unlike-count-{{$comment->id}}">0</span>
    <img alt="dislike icon" class="unlike-com-image w-6" loading="lazy" id="unlike-com-image-{{$comment->id}}"
        src="{{ asset('files/icon/dislike-finger.svg') }}">
</span>