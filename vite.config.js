import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/quiz.js', 'resources/js/videoplayer.js','resources/js/ratecourse.js','resources/js/module.js'],
            refresh: true,
        }),
    ],
    build: {
        sourcemap: false,  // Disable source maps globally
    },
});
