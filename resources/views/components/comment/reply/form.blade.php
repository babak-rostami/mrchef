@props(['form_action'])

<form action="{{ $form_action }}" method="POST" id="store-bcom-rep-form" role="form" class="block mt-4">
    @csrf

    <input type="hidden" name="comment_id" id="bcom-rep-comment-id">

    <textarea required id="bcom-rep-body" name="body" class="w-full h-44 p-4 text-2xl border border-gray-200 outline-0 rounded-2xl
            hover:shadow-blue-100 hover:shadow-md duration-300 mt-8
            focus:outline-4 focus:outline-blue-200" placeholder="دیدگاه خود را بنویسید..."></textarea>

    <!-- نمایش پیام خطا -->
    <div id="bcom-rep-body-error" class="bg-red-100 text-lg mb-2 pr-2 py-2 rounded hidden"></div>

    <!-- submit button -->
    <button onclick="sendComment('store-bcom-rep-form','bcom-rep-body','reply')" type="button" id="bcom-reply-submit"
        class="w-full bg-blue-500 text-white rounded-2xl py-2 text-2xl cursor-pointer hover:bg-blue-600">
        ثبت نظر</button>

</form>