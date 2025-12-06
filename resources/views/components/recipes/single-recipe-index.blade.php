@props(['recipe'])

@if ($recipe)
    <a class="flex flex-col mt-4 items-start mx-1
    hover:-translate-y-4 duration-500"
        href="{{ route('recipes.show', $recipe->slug) }}">
        <!-- IMAGE -->
        <img class="h-72 object-contain rounded-2xl self-center md:self-start" src="{{ $recipe->image_url }}"
            alt="{{ $recipe->title }}">
        <!-- TEXT BOX -->
        <div class="flex flex-col items-start py-4 gap-4 mt-2">
            <span class="text-2xl font-extrabold text-gray-500 self-center md:self-start">{{ $recipe->title }}</span>

            <span class="whitespace-pre-line">{{ $recipe->description }}</span>
        </div>
    </a>
@endif
