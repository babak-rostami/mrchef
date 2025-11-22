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
                'resources/js/category/index.js',

                'resources/css/page/home.css',

                'resources/css/test.css',
                'resources/js/test.js',

                'resources/css/recipe/index.css',
                'resources/css/recipe/create.css',
                'resources/js/recipe/create.js',
                'resources/css/recipe/edit.css',
                'resources/js/recipe/edit.js',

                'resources/css/ingredient/index.css',
                'resources/css/ingredient/create.css',
                'resources/js/ingredient/create.js',
                'resources/css/ingredient/edit.css',
                'resources/js/ingredient/edit.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
