// import { defineConfig } from "vite";
// import laravel from "laravel-vite-plugin";

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: [
//                 "resources/css/app.css",
//                 "resources/sass/app.scss",
//                 "resources/js/app.js",
//                 "resources/js/productsIndex.js",
//             ],
//             refresh: true,
//         }),
//     ],
// });

import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel(["resources/js/app.js"]),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
