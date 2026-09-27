<?php

namespace App\Support\Schema;

class SiteSchema
{
    public static function organization(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Mrchef',
            'url' => url('/'),
            'logo' => config('images.ftp_path') . '/files/icon/chef-icon-36.png',
            'sameAs' => [
                'https://www.instagram.com/mrchef.iran/',
                'https://www.youtube.com/@behnamrostami',
            ],
        ];
    }

    public static function website(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'Mrchef',
            'url' => url('/'),
        ];
    }
}
