<div class="p-4 bg-white shadow-sm hover:shadow-lg rounded-2xl flex flex-col">

    <!-- Image + Title -->
    <div class="flex items-center mb-3">
        <img src="{{ $category->thumb_url }}" class="w-14 h-14 rounded-lg object-cover">
        <div class="mr-3 flex flex-col">
            <h6 class="font-bold">{{ $category->name }}</h6>
            <span class="text-gray-500 text-sm">{{ $category->name_en }}</span>
            @isset($category->parent)
                <span class="text-gray-500 text-sm">پدر: {{ $category->parent->name }}</span>
            @endisset
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-center mt-auto pt-3">

        <a href="{{ route('admin.category.edit', $category->slug) }}"
            class="px-4 py-1.5 bg-yellow-500 text-white text-sm rounded-xl shadow hover:bg-yellow-600 transition">
            ویرایش
        </a>

        {{-- <button onclick="openModal('deleteCategory-{{ $category->id }}')"
                class="px-4 py-1.5 cursor-pointer bg-red-500 mr-2 text-white rounded-xl shadow hover:bg-red-600">
                حذف دسته بندی
            </button>
        --}}

        {{-- <x-modal id="deleteCategory-{{ $category->id }}">
            <h2 class="text-xl font-bold mb-3">حذف دسته بندی</h2>

            <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex flex-col mt-2 mb-4">
                    <span>{{ $category->name }}</span>
                    <span class="text-red-600 font-bold">هشدار</span>
                    <span>مطمئنید میخواهید دسته بندی حذف شود؟</span>
                </div>

                <div class="flex">
                    <button type="button" onclick="closeModal('deleteCategory-{{ $category->id }}')"
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

</div>
