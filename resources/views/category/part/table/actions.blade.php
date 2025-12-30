<div class="flex items-center gap-3">

    {{-- View --}}
    {{-- <a href="{{ route('admin.category.show', $row->slug) }}"
        class="text-gray-500 hover:text-gray-800 cursor-pointer flex items-center gap-1">
        <i class="fa fa-eye"></i>
        <span class="hidden md:inline">مشاهده</span>
    </a> --}}

    {{-- Edit --}}
    <a href="{{ route('admin.category.edit', $row->slug) }}"
        class="text-blue-500 hover:text-blue-800 cursor-pointer flex items-center gap-1">
        <i class="fa fa-pen"></i>
        <span class="hidden md:inline">ویرایش</span>
    </a>

    {{-- Delete --}}

    {{-- <button class="text-red-500 hover:text-red-800 cursor-pointer flex items-center gap-1"
        onclick="openModal('deleteCategory-{{ $row->id }}')">
        <i class="fa fa-trash"></i>
        <span class="hidden md:inline">حذف</span>
    </button>

    <x-modal id="deleteCategory-{{ $row->id }}">
        <h2 class="text-xl font-bold mb-3">حذف دسته بندی</h2>

        <form action="{{ route('admin.category.destroy', $row->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex flex-col mt-2 mb-4">
                <span>{{ $row->name }}</span>
                <span class="text-red-600 font-bold">هشدار</span>
                <span>مطمئنید میخواهید دسته بندی حذف شود؟</span>
            </div>

            <div class="flex">
                <button type="button" onclick="closeModal('deleteCategory-{{ $row->id }}')"
                    class="bg-gray-400 hover:bg-gray-500 cursor-pointer text-white px-4 py-2 rounded">
                    نمیخواهم حذف شود
                </button>

                <button type="submit" onclick="submitForm(this,'در حال حذف...')"
                    class="bg-red-600 hover:bg-red-400 cursor-pointer mr-2 text-white px-4 py-2 rounded">
                    حذف شود
                </button>
            </div>
        </form>
    </x-modal> --}}

</div>
