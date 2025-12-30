<!-- Actions -->
<div class="flex">

    <a href="{{ route('admin.unit.edit', $row->id) }}"
        class="text-blue-500 hover:text-blue-800 cursor-pointer flex items-center gap-1 mx-4">
        <i class="fa fa-pen"></i>
        <span class="hidden md:inline">ویرایش</span>
    </a>

    {{-- <button onclick="openModal('deleteUnit-{{ $row->id }}')"
        class="text-red-500 hover:text-red-800 cursor-pointer flex items-center gap-1 mr-4">
        <i class="fa fa-times"></i>
        <span class="hidden md:inline">حذف</span>
    </button>

    <x-modal id="deleteUnit-{{ $row->id }}">
        <h2 class="text-xl font-bold mb-3">حذف واحد اندازه گیری</h2>

        <form action="{{ route('admin.unit.destroy', $row->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex flex-col mt-2 mb-4">
                <span>{{ $row->name }}</span>
                <span class="text-red-600 font-bold">هشدار</span>
                <span>مطمئنید میخواهید واحد اندازه گیری حذف شود؟</span>
            </div>

            <div class="flex">
                <button type="button" onclick="closeModal('deleteUnit-{{ $row->id }}')"
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
