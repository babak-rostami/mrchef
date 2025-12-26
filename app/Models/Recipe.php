<?php

namespace App\Models;

use App\Services\ImageService;
use App\Traits\Imageable;
use Babak\Elasticsearch\Traits\ElasticsearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Recipe extends Model
{
    use Imageable, HasFactory, ElasticsearchableTrait;

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_PENDING = 2;
    const EDITOR_PATH = 'recipe/editor/1';
    const EDITOR_KEY = 'recipe';
    const STORE_IMAGE_PATH = 'recipe';

    protected $fillable = ['category_id', 'user_id', 'title', 'slug', 'description', 'body', 'status', 'image', 'time_prepare', 'time_cook', 'servings'];


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($recipe) {

            $recipe->load(['editorImages']);

            $imageService = resolve(ImageService::class);

            // حذف عکس اصلی
            if ($recipe->image) {
                $imageService->delete($recipe->image);
            }

            // حذف تصاویر CKEditor
            foreach ($recipe->editorImages as $editorImage) {
                $imageService->delete($editorImage->image);
                $editorImage->delete();
            }
        });
    }

    protected static function elasticsearchProperties(): array
    {
        return [
            'title' => [
                'type' => 'text',
                'analyzer' => 'autocomplete_index',
                'search_analyzer' => 'autocomplete_search',
            ]
        ];
    }


    protected static function elasticsearchFields(): array
    {
        return ['title'];
    }

    public static function elasticsearchIndex(): string
    {
        return 'recipes';
    }

    public function editorImages(): MorphMany
    {
        return $this->morphMany(CkeditorImage::class, 'editorable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function commentsWithUser(): MorphMany
    {
        return $this
            ->morphMany(Comment::class, 'commentable')
            ->with(['user:id,name,username,image']);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredients', 'recipe_id', 'ingredient_id')->withPivot(['amount']);
    }

    public function ingredientsWithUnit(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredients', 'recipe_id', 'ingredient_id')
            ->withPivot(['amount', 'unit_id'])
            ->join('units', 'units.id', '=', 'recipe_ingredients.unit_id')
            ->select([
                'ingredients.id',
                'ingredients.name',
                'ingredients.image',
                'recipe_ingredients.amount',
                'units.name as unit_name'
            ]);
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function defaultImage(): string
    {
        return asset('files/icon/default-recipe.jpg');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
