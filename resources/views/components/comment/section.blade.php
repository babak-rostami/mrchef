@props([
    'page', //recipe for example
    'object', // $recipe for example
    'comments',
    'has_more_comments' => false,
    'form_action' => route('comment.store'),
])
<x-comment.form :page="$page" :object="$object" :form_action="$form_action" />

<div id="comments-box" class="mb-12" data-page="{{ $page }}" data-object-id="{{ $object->id }}"
    data-offset="{{ $comments->count() }}">
    @foreach ($comments as $comment)
        <x-comment.item.show :comment="$comment" />
    @endforeach
</div>

@if ($has_more_comments)
    <button id="load-more-comments-btn" type="button" class="bcomment-load-more-btn w-full mt-6 py-4 text-xl font-bold rounded-2xl bg-blue-600 text-white
                   hover:bg-blue-700 cursor-pointer transition-colors duration-300 shadow-lg">
        نمایش نظرات بیشتر
    </button>
@endif

<x-comment.reply.modal :form_action="$form_action" />