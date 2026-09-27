<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipe;
use App\Support\Schema\PageSchema;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        // این عددها واقعی و از دیتابیس هستن (نه ثابت توی کد)
        // تا صفحه‌ی درباره‌ما با رشد سایت خودش به‌روز بمونه
        $recipesCount = Recipe::active()->count();
        $categoriesCount = Category::count();
        $aboutSchema = PageSchema::build('AboutPage', 'درباره ما', route('about'));

        return view('frontend.about.index', compact('recipesCount', 'categoriesCount', 'aboutSchema'));
    }
}
