<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * فایل ایندکس سایت‌مپ: یک سایت‌مپ برای صفحات مهم + یک سایت‌مپ به‌ازای
     * هر Recipe::SITEMAP_CHUNK_SIZE رسپی.
     */
    public function index(): Response
    {
        $xml = Cache::remember('sitemap:index', now()->addHours(6), function () {
            $lastId = Recipe::active()->max('id');
            $lastChunk = $lastId ? intdiv($lastId - 1, Recipe::SITEMAP_CHUNK_SIZE) + 1 : 0;

            return view('sitemap.index', compact('lastChunk'))->render();
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * سایت‌مپ صفحات مهم و ثابت سایت (خانه، لیست رسپی‌ها، دسته‌بندی‌ها، درباره ما، تماس با ما).
     */
    public function pages(): Response
    {
        $xml = Cache::remember('sitemap:pages', now()->addHours(6), function () {
            $categories = Cache::remember('categories', 3600, fn() => Category::all());

            return view('sitemap.pages', compact('categories'))->render();
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * سایت‌مپ رسپی‌ها، تکه‌تکه‌شده بر اساس id.
     *
     * هر رسپی همیشه توی یک فایل مشخص می‌مونه (chunk = intdiv(id-1, SIZE) + 1،
     * نگاه کن به Recipe::getSitemapChunkAttribute)، پس با اضافه‌شدن رسپی‌های
     * جدید، فایل‌های قدیمی هیچ‌وقت عوض نمی‌شن — فقط آخرین فایل (که هنوز داره
     * پر میشه) تغییر می‌کنه. به همین خاطر فایل‌های قدیمی رو برای مدت طولانی
     * کش می‌کنیم، ولی هر Save/Delete رسپی، کش همون چانک خودش رو پاک می‌کنه
     * (نگاه کن به RecipeObserver).
     */
    public function recipes(string $chunk): Response
    {
        $chunk = (int) $chunk;

        $lastId = Recipe::active()->max('id');
        $lastChunk = $lastId ? intdiv($lastId - 1, Recipe::SITEMAP_CHUNK_SIZE) + 1 : 0;

        $ttl = ($chunk < $lastChunk) ? now()->addYear() : now()->addHours(3);

        $xml = Cache::remember("sitemap:recipes:{$chunk}", $ttl, function () use ($chunk) {
            $minId = ($chunk - 1) * Recipe::SITEMAP_CHUNK_SIZE + 1;
            $maxId = $chunk * Recipe::SITEMAP_CHUNK_SIZE;

            $recipes = Recipe::active()
                ->whereBetween('id', [$minId, $maxId])
                ->orderBy('id')
                ->get(['slug', 'updated_at']);

            return view('sitemap.recipes', compact('recipes'))->render();
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
