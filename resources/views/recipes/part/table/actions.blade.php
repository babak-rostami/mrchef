<!-- Actions -->
<div class="flex justify-center mt-auto pt-3">

    <a href="{{ route('recipes.show', $row->slug) }}" target="_blank"
        class="text-gray-500 hover:text-gray-800 cursor-pointer flex items-center gap-1">
        <i class="fa fa-eye"></i>
        <span class="hidden md:inline">مشاهده</span>
    </a>

    <a href="{{ route('admin.recipes.edit', $row->slug) }}"
        class="text-blue-500 hover:text-blue-800 cursor-pointer flex items-center gap-1 mx-4">
        <i class="fa fa-pen"></i>
        <span class="hidden md:inline">ویرایش</span>
    </a>


    <a href="{{ route('admin.recipe.ingredients.index', $row->slug) }}"
        class="text-green-500 hover:text-green-800 cursor-pointer flex items-center gap-1">
        <i class="fa fa-dot-circle"></i>
        <span class="hidden md:inline">مواد اولیه</span>
    </a>


    {{-- <button onclick="openModal('deleteRecipe-{{ $row->id }}')"
        class="text-red-500 hover:text-red-800 cursor-pointer flex items-center gap-1 mr-4">
        <i class="fa fa-times"></i>
        <span class="hidden md:inline">حذف</span>
    </button>

    <x-modal id="deleteRecipe-{{ $row->id }}">
        <h2 class="text-xl font-bold mb-3">حذف رسپی</h2>

        <form action="{{ route('admin.recipes.destroy', $row->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex flex-col mt-2 mb-4">
                <span>{{ $row->title }}</span>
                <span class="text-red-600 font-bold">هشدار</span>
                <span>مطمئنید میخواهید رسپی حذف شود؟</span>
            </div>

            <div class="flex">
                <button type="button" onclick="closeModal('deleteRecipe-{{ $row->id }}')"
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
