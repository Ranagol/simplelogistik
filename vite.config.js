import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
//Element Plus
import AutoImport from 'unplugin-auto-import/vite';
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers';
import Components from 'unplugin-vue-components/vite';

import fs from 'fs';
import {homedir} from 'os'
import {resolve} from 'path'

export default defineConfig({
    server: detectServerConfig('simplelogistik.test'),
    define: {
        __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: true,
    },
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
        AutoImport({
            resolvers: [ElementPlusResolver()],
        }),
        Components({
            resolvers: [ElementPlusResolver()],
        }),
    ],
    resolve: {
        alias: {
            '@Shared': fileURLToPath(new URL('resources/js/Shared', import.meta.url)),
            '@Pages': fileURLToPath(new URL('resources/js/Pages', import.meta.url)),
            '@Components': fileURLToPath(new URL('resources/js/Components', import.meta.url)),
            '@Contents': fileURLToPath(new URL('resources/js/Contents', import.meta.url)),
            '@Config': fileURLToPath(new URL('resources/js/config', import.meta.url)),
        },
    },
});


function detectServerConfig(host) {
    let keyPath = resolve(homedir(), `.config/valet/Certificates/${host}.key`)
    let certificatePath = resolve(homedir(), `.config/valet/Certificates/${host}.crt`)

    if (!fs.existsSync(keyPath)) {
        return {}
    }

    if (!fs.existsSync(certificatePath)) {
        return {}
    }

    return {
        hmr: {host},
        host,
        https: {
            key: fs.readFileSync(keyPath),
            cert: fs.readFileSync(certificatePath),
        },
    }
}