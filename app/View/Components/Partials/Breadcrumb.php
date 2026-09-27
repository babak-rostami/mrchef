<?php

namespace App\View\Components\Partials;

use App\Support\Schema\BreadcrumbSchema;
use Illuminate\View\Component;
use Illuminate\View\View;

class Breadcrumb extends Component
{
    public array $breadcrumbSchema = [];

    public function __construct(
        public string $panel = 'user',
        public ?string $page = null,
        public array $parents = [],
    ) {
        // اسکیمای BreadcrumbList فقط برای صفحات کاربری لازمه؛
        // پنل ادمین که noindex هست بهش نیازی نداره.
        if ($this->panel === 'user' && $this->page) {
            $this->breadcrumbSchema = BreadcrumbSchema::build($this->parents, $this->page);
        }
    }

    public function render(): View
    {
        return view('components.partials.breadcrumb');
    }
}
