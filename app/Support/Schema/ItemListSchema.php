<?php

namespace App\Support\Schema;

use Illuminate\Support\Collection;

class ItemListSchema
{
    public static function buildForRecipes(Collection $recipes): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'itemListElement' => $recipes->values()->map(function ($recipe, $index) {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'url' => route('recipes.show', $recipe->slug),
                ];
            })->all(),
        ];
    }
}
