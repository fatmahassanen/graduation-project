import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(({ mode }) => {
    const isProduction = mode === 'production';
    
    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
            tailwindcss(),
        ],
        server: {
            // Development: Hot module replacement for fast refresh
            hmr: {
                host: 'localhost',
            },
            watch: {
                ignored: ['**/storage/framework/views/**'],
            },
        },
        build: {
            // Production: Minified and optimized assets
            minify: isProduction ? 'esbuild' : false,
            sourcemap: !isProduction,
            rollupOptions: {
                output: {
                    manualChunks: undefined,
                },
            },
        },
    };
});
