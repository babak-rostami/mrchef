import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/user/dashboard.css',
                'resources/css/user/login.css',
                'resources/css/user/register.css',

                'resources/css/category/index.css',
                'resources/css/category/edit.css',

                'resources/css/page/home.css',

                'resources/js/category/index.js',

                'resources/css/test.css',
                'resources/js/test.js',

                'resources/css/recipe/index.css',
                'resources/css/recipe/create.css',
                'resources/js/recipe/create.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
