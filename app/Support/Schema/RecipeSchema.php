<?php

namespace App\Support\Schema;

use App\Models\Recipe;
use Illuminate\Support\Collection;

/**
 * اسکیمای schema.org/Recipe برای صفحه‌ی نمایش یک رسپی.
 * خروجی این کلاس مستقیم به ویو پاس داده میشه و ویو فقط با
 * <x-schema-tag :data="$recipeSchema" /> رندرش می‌کنه؛ هیچ منطقی
 * برای ساختن JSON توی بلید نیست.
 */
class RecipeSchema
{
    public static function build(Recipe $recipe, Collection $ingredients): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Recipe',
            'name' => $recipe->title,
            'image' => [$recipe->image_url],
            'author' => [
                '@type' => 'Person',
                'name' => $recipe->user->name ?? 'Mrchef',
            ],
            'datePublished' => $recipe->created_at->toIso8601String(),
            'dateModified' => $recipe->updated_at->toIso8601String(),
            'description' => $recipe->description,
            'recipeIngredient' => $ingredients
                ->map(fn($ingredient) => trim("{$ingredient->amount} {$ingredient->unit_name} {$ingredient->name}"))
                ->values()
                ->all(),
            'recipeInstructions' => $recipe->plain_body,
        ];

        if ($recipe->time_prepare) {
            $schema['prepTime'] = 'PT' . (int) $recipe->time_prepare . 'M';
        }

        if ($recipe->time_cook) {
            $schema['cookTime'] = 'PT' . (int) $recipe->time_cook . 'M';
        }

        if ($recipe->time_prepare || $recipe->time_cook) {
            $schema['totalTime'] = 'PT' . ((int) $recipe->time_prepare + (int) $recipe->time_cook) . 'M';
        }

        if ($recipe->servings) {
            $schema['recipeYield'] = $recipe->servings . ' نفر';
        }

        if ($recipe->category) {
            $schema['recipeCategory'] = $recipe->category->name;
        }

        // توجه: ویدیوی آپارات عمداً اینجا نمیاد — فقط برای نمایش توی خود
        // سایته و قرار نیست ایندکس بشه.

        return $schema;
    }
}
