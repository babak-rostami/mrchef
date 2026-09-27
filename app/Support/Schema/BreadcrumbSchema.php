<?php

namespace App\Support\Schema;

class BreadcrumbSchema
{
    /**
     * @param  array<int, array{url: string, title: string}>  $parents
     */
    public static function build(array $parents, string $page): array
    {
        $items = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'خانه',
                'item' => route('home'),
            ],
        ];

        $position = 2;
        foreach ($parents as $parent) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $parent['title'],
                'item' => $parent['url'],
            ];
        }

        $items[] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => $page,
        ];

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }
}
