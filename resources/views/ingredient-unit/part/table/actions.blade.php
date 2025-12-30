 <!-- Actions -->
 <div class="flex">

     <button onclick="openModal('editIngredientUnit-{{ $row->id }}')"
         class="text-blue-500 hover:text-blue-800 cursor-pointer flex items-center gap-1 ml-4">
         <i class="fa fa-pen"></i>
         <span class="hidden md:inline">ویرایش</span>
     </button>

     <x-modal id="editIngredientUnit-{{ $row->id }}">
         <h2 class="text-xl font-bold mb-3">ویرایش</h2>

         <form id="ingredient-unit-update-form-{{ $row->id }}"
             action="{{ route('admin.ingredient.units.update', ['ingredient' => $row->pivot->ingredient_id, 'unit' => $row->id]) }}"
             method="POST" enctype="multipart/form-data" class="w-full space-y-6 ingredient-unit-update-form">
             @csrf
             @method('PUT')

             {{-- unit weight --}}
             <x-form.edit.number name="unit_weight_in_gram" id="unit_weight_in_gram-{{ $row->id }}"
                 title="وزن هر واحد (به گرم)" :required="true" placeholder="مثال: 16"
                 msg="هر واحد از این ماده چند گرم است؟" :roles="['min-number' => 1, 'max-number' => 500000]" :value="$row->pivot->unit_weight_in_gram" />

             {{-- SUBMIT --}}
             <x-form.edit.submit title="ویرایش وزن واحد اندازه گیری" />
         </form>

     </x-modal>

     {{-- <button onclick="openModal('deleteIngredient-{{ $row->id }}')"
         class="text-red-500 hover:text-red-800 cursor-pointer flex items-center gap-1 mx-4">
         <i class="fa fa-pen"></i>
         <span class="hidden md:inline">حذف وزن واحد</span>
     </button>

     <x-modal id="deleteIngredient-{{ $row->id }}">
         <h2 class="text-xl font-bold mb-3">حذف وزن واحد</h2>

         <form
             action="{{ route('admin.ingredient.units.destroy', ['ingredient' => $row->pivot->ingredient_id, 'unit' => $row->id]) }}"
             method="POST">
             @csrf
             @method('DELETE')

             <div class="flex flex-col mt-2 mb-4">
                 <span>{{ $row->name }}</span>
                 <span class="text-red-600 font-bold">هشدار</span>
                 <span>مطمئنید میخواهید واحد اندازه گیری ماده اولیه حذف شود؟</span>
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
