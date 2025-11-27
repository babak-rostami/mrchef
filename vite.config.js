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
                'resources/js/recipe/index.js',
                'resources/css/recipe/create.css',
                'resources/js/recipe/create.js',
                'resources/css/recipe/edit.css',
                'resources/js/recipe/edit.js',

                'resources/css/ingredient/index.css',
                'resources/js/ingredient/index.js',
                'resources/css/ingredient/create.css',
                'resources/js/ingredient/create.js',
                'resources/css/ingredient/edit.css',
                'resources/js/ingredient/edit.js',

                'resources/css/unit/index.css',
                'resources/js/unit/index.js',
                'resources/css/unit/create.css',
                'resources/js/unit/create.js',
                'resources/css/unit/edit.css',
                'resources/js/unit/edit.js',

                'resources/css/recipe-ingredient/index.css',
                'resources/js/recipe-ingredient/index.js',

                'resources/css/ingredient-unit/index.css',
                'resources/js/ingredient-unit/index.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
