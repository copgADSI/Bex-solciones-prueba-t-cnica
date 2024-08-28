import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import Vue from '@vitejs/plugin-vue'
import path from "path";

export default defineConfig({
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost'
        }
    },
    plugins: [laravel({
        input: [
            'resources/js/app.js',
            'resources/scss/app.scss'
        ],
        refresh: true,
    }), Vue(),
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
            "@": path.resolve(__dirname, "resources/js"),
            "~": path.resolve(__dirname, "node_modules"),
            '/img': path.resolve(__dirname, 'public/img'),
            '~coreui': path.resolve(__dirname, 'node_modules/@coreui/coreui'),
        },
    },
});
