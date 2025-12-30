<!-- Actions -->
<div class="flex justify-center mt-auto pt-3">

    <a href="{{ route('admin.ingredient.edit', $row->slug) }}"
        class="text-blue-500 hover:text-blue-800 cursor-pointer flex items-center gap-1 ml-4">
        <i class="fa fa-pen"></i>
        <span class="hidden md:inline">ویرایش</span>
    </a>

    <a href="{{ route('admin.ingredient.units.index', $row->slug) }}"
        class="text-green-500 hover:text-green-800 cursor-pointer flex items-center gap-1">
        <i class="fa fa-dot-circle"></i>
        <span class="hidden md:inline">واحد های اندازه گیری</span>
    </a>

    {{-- <button onclick="openModal('deleteIngredient-{{ $row->id }}')"
        class="px-4 py-1.5 cursor-pointer bg-red-500 mr-2 text-white rounded-xl shadow hover:bg-red-600">
        حذف ماده اولیه
    </button>

    <x-modal id="deleteIngredient-{{ $row->id }}">
        <h2 class="text-xl font-bold mb-3">حذف ماده اولیه</h2>

        <form action="{{ route('admin.ingredient.destroy', $row->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex flex-col mt-2 mb-4">
                <span>{{ $row->name }}</span>
                <span class="text-red-600 font-bold">هشدار</span>
                <span>مطمئنید میخواهید ماده اولیه حذف شود؟</span>
            </div>

            <div class="flex">
                <button type="button" onclick="closeModal('deleteIngredient-{{ $row->id }}')"
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
