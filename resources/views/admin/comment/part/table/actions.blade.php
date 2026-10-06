<div class="flex justify-center gap-3">

    <a href="{{ route('admin.comments.edit', $row->id) }}"
        class="text-blue-500 hover:text-blue-800 cursor-pointer flex items-center gap-1">
        <i class="fa fa-pen"></i>
        <span class="hidden md:inline">ویرایش</span>
    </a>

    <button onclick="openModal('deleteComment-{{ $row->id }}')"
        class="text-red-500 hover:text-red-800 cursor-pointer flex items-center gap-1">
        <i class="fa fa-trash"></i>
        <span class="hidden md:inline">حذف</span>
    </button>

    <x-modal id="deleteComment-{{ $row->id }}">
        <h2 class="text-xl font-bold mb-3">حذف نظر</h2>

        <form action="{{ route('admin.comments.destroy', $row->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex flex-col mt-2 mb-4">
                <span class="text-red-600 font-bold">هشدار</span>
                <span>مطمئنید میخواهید این نظر حذف شود؟ اگه این نظر پاسخ هم داشته باشه، پاسخ‌هاش هم حذف میشن.</span>
            </div>

            <div class="flex">
                <button type="button" onclick="closeModal('deleteComment-{{ $row->id }}')"
                    class="bg-gray-400 hover:bg-gray-500 cursor-pointer text-white px-4 py-2 rounded">
                    نمیخواهم حذف شود
                </button>

                <button type="submit" onclick="submitForm(this,'در حال حذف...')"
                    class="bg-red-600 hover:bg-red-400 cursor-pointer mr-2 text-white px-4 py-2 rounded">
                    حذف شود
                </button>
            </div>
        </form>
    </x-modal>

</div>