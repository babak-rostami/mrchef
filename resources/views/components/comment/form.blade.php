@props(['page', 'object', 'form_action'])

<form class="mt-8" action="{{ $form_action }}" method="post" id="store-bcom-form">

    @csrf

    <input type="hidden" name="object_page" value="{{ $page }}">
    <input type="hidden" name="object_id" value="{{ $object->id }}">

    <textarea id="bcom-body" name="body" placeholder="نظر خود را اینجا بنویسید..." class="w-full border border-gray-200 outline-0 rounded-2xl
            hover:shadow-blue-100 hover:shadow-md duration-300 mt-8
            focus:outline-4 focus:outline-blue-200
            text-2xl h-44 p-4"></textarea>

    <!-- نمایش پیام خطا -->
    <div id="bcom-body-error" class="bg-red-100 text-lg mb-2 pr-2 py-2 rounded hidden"></div>

    <!-- نمایش خطا از سمت سرور -->
    @error('body')
        <p class="bg-red-100 text-lg mb-2 pr-2 py-2 rounded">{{ $message }}</p>
    @enderror

    <!-- submit button -->
    <button onclick="sendComment('store-bcom-form','bcom-body','comment')" type="button" id="bcom-submit"
        class="w-full bg-blue-500 text-white rounded-2xl py-2 text-2xl cursor-pointer hover:bg-blue-600">
        ثبت نظر</button>

</form>