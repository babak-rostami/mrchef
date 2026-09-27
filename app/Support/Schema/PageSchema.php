<?php

namespace App\Support\Schema;

class PageSchema
{
    public static function build(string $type, string $name, string $url): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => $type,
            'name' => $name,
            'url' => $url,
            'isPartOf' => [
                '@type' => 'WebSite',
                'name' => 'Mrchef',
                'url' => url('/'),
            ],
        ];
    }
}
