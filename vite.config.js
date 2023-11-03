import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';


export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
        //   '@': fileURLToPath(new URL('./resources', import.meta.url)),
        //   '@themeConfig': fileURLToPath(new URL('./themeConfig.ts', import.meta.url)),
        //   '@core': fileURLToPath(new URL('./src/@core', import.meta.url)),
        //   '@layouts': fileURLToPath(new URL('./src/@layouts', import.meta.url)),
        //   '@images': fileURLToPath(new URL('./src/assets/images/', import.meta.url)),
        //   '@styles': fileURLToPath(new URL('./src/styles/', import.meta.url)),
        //   '@configured-variables': fileURLToPath(new URL('./src/styles/variables/_template.scss', import.meta.url)),
        //   '@axios': fileURLToPath(new URL('./src/plugins/axios', import.meta.url)),
        //   '@validators': fileURLToPath(new URL('./resources/js/VuexyStuff/validators', import.meta.url)),
        //   'apexcharts': fileURLToPath(new URL('node_modules/apexcharts-clevision', import.meta.url)),
        },
    },
});
