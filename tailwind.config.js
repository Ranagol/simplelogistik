import forms from '@tailwindcss/forms';
import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './node_modules/flowbite/**/*.js'
    ],

    theme: {
        extend: {
            backgroundColor: {
                primary: {
                    '50': '#effafc',
                    '100': '#d6f0f7',
                    '200': '#b1e2f0',
                    '300': '#7ccce4',
                    '400': '#3facd1',
                    '500': '#2596be',
                    '600': '#20749a',
                    '700': '#215e7d',
                    '800': '#234f67',
                    '900': '#214358',
                    '950': '#112a3b',
                },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'auth': "url('/images/auth-bg.jpg')",
                'auth1': "url('/images/auth-bg-1.jpg')",
                'auth2': "url('/images/auth-bg-2.jpg')",
                'auth3': "url('/images/auth-bg-3.jpg')",
            },
        },
    },

    plugins: [forms, require('flowbite/plugin')],
};
