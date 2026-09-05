import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                //-------------------------------------------------------------
                //-------------------------for admin---------------------------
                //-------------------------------------------------------------

                //----------------------------user-----------------------------
                "resources/css/user/dashboard.css",
                "resources/js/user/reset-password.js",

                //--------------------------category---------------------------
                "resources/css/category/index.css",
                "resources/js/category/index.js",
                "resources/js/category/create.js",
                "resources/js/category/edit.js",

                //--------------------------recipe-----------------------------
                "resources/js/recipe/index.js",
                "resources/js/recipe/create.js",
                "resources/js/recipe/edit.js",

                //------------------------ingredient---------------------------
                "resources/js/ingredient/index.js",
                "resources/js/ingredient/create.js",
                "resources/js/ingredient/edit.js",

                //--------------------------unit-------------------------------
                "resources/js/unit/index.js",
                "resources/js/unit/create.js",
                "resources/js/unit/edit.js",

                //-------------------recipe ingredient-------------------------
                "resources/js/recipe-ingredient/index.js",

                //---------------------ingredient unit--------------------------
                "resources/js/ingredient-unit/index.js",

                //-------------------------------------------------------------
                //-------------------------for frontend------------------------
                //-------------------------------------------------------------
                "resources/css/page/home.css",
                "resources/js/page/home.js",

                //-------------------------recipe------------------------------
                "resources/css/frontend/recipe/index.css",
                "resources/js/frontend/recipe/index.js",
                "resources/css/frontend/recipe/show.css",
                "resources/js/frontend/recipe/show.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
