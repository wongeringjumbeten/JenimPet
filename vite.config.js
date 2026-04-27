import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // <-- Impor di sini

export default defineConfig({
    plugins: [
        tailwindcss(), // <-- Panggil di sini, sebelum laravel()
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});

server: {
    hmr: {
        overlay: false
    }
}
