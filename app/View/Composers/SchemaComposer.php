<?php

namespace App\View\Composers;

use App\Support\Schema\SiteSchema;
use Illuminate\View\View;

/**
 * اسکیمای Organization و WebSite توی همه‌ی صفحات یکسانه (چون توی layout اصلی هست)،
 * پس به‌جای اینکه هر کنترلری مجبور باشه دستی پاسش بده، این composer خودکار
 * به لایوت اصلی share‌ش می‌کنه.
 */
class SchemaComposer
{
    public function compose(View $view): void
    {
        $view->with('organizationSchema', SiteSchema::organization());
        $view->with('websiteSchema', SiteSchema::website());
    }
}
