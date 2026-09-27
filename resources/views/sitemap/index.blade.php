<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ route('sitemap.pages') }}</loc>
    </sitemap>
    @for ($chunk = 1; $chunk <= $lastChunk; $chunk++)
        <sitemap>
            <loc>{{ route('sitemap.recipes', $chunk) }}</loc>
        </sitemap>
    @endfor
</sitemapindex>