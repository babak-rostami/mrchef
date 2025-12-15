@props(['form_action'])

<div id="bcom-reply-overlay" class="fixed inset-0 hidden bg-black/50 z-50 overflow-y-auto pt-20 justify-items-center">

    <div id="bcom-reply" class="bg-white rounded-2xl shadow-xl p-6 w-auto min-w-96
                max-w-full mx-4 relative
                transform opacity-0 -translate-y-6 scale-95 transition-all duration-300">

        <button class="absolute top-3 left-4 text-gray-600 hover:text-black"
            onclick="closeBComReplyModal('bcom-reply')">✕</button>

        <x-comment.reply.form :form_action="$form_action" />

    </div>
</div>