@props([
    'page', //recipe for example
    'object', // $recipe for example
    'comments',
    'form_action' => route('comment.store'),
])
<x-comment.form :page="$page" :object="$object" :form_action="$form_action" />

<div id="comments-box" class="mb-48">
    @foreach ($comments as $comment)
        <x-comment.item.show :comment="$comment" :has_reply="1" :is_reply="0" />
    @endforeach
</div>

<x-comment.reply.modal :form_action="$form_action" />
