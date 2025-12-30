<!-- Actions -->
<div class="flex pt-3">

    <button onclick="openModal('editIngredientUnit-{{ $row->id }}')"
        class="text-blue-500 hover:text-blue-800 cursor-pointer flex items-center gap-1 ml-4">
        <i class="fa fa-pen"></i>
        <span class="hidden md:inline">ویرایش</span>
    </button>
    <x-modal id="editIngredientUnit-{{ $row->id }}">
        <h2 class="text-xl font-bold mb-3">ویرایش</h2>

        <form id="recipe-ingredient-update-form-{{ $row->id }}"
            action="{{ route('admin.recipe.ingredients.update', ['recipe' => $row->recipe_id, 'ingredient' => $row->id]) }}"
            method="POST" enctype="multipart/form-data" class="w-full space-y-6 recipe-ingredient-update-form">
            @csrf
            @method('PUT')

            {{-- SELECT unit --}}
            <x-form.edit.readonly title="واحد اندازه گیری" id="unit_id-{{ $row->id }}" :value="$row->unit_name" />

            {{-- amount --}}
            <x-form.edit.number name="amount" id="amount-{{ $row->id }}" title="مقدار لازم" :required="true"
                placeholder="مثال: 16" msg="مقدار لازم را وارد کنید" :value="$row->amount" :roles="['min-number' => 1, 'max-number' => 500000]" />

            {{-- SUBMIT --}}
            <x-form.edit.submit title="ویرایش مقدار لازم" />
        </form>

    </x-modal>

    <button onclick="openModal('deleteRecipeIngredient-{{ $row->id }}')"
        class="text-red-500 hover:text-red-800 cursor-pointer flex items-center gap-1 mx-4">
        <i class="fa fa-pen"></i>
        <span class="hidden md:inline">حذف مقدار لازم</span>
    </button>

    <x-modal id="deleteRecipeIngredient-{{ $row->id }}">
        <h2 class="text-xl font-bold mb-3">حذف مقدار لازم</h2>

        <form
            action="{{ route('admin.recipe.ingredients.destroy', ['recipe' => $row->recipe_id, 'ingredient' => $row->id]) }}"
            method="POST">
            @csrf
            @method('DELETE')

            <div class="flex flex-col mt-2 mb-4">
                <span>{{ $row->name }}</span>
                <span class="text-red-600 font-bold">هشدار</span>
                <span>مطمئنید میخواهید ماده اولیه حذف شود؟</span>
            </div>

            <div class="flex">
                <button type="button" onclick="closeModal('deleteRecipeIngredient-{{ $row->id }}')"
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
