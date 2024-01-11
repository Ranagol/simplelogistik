import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
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

    plugins: [forms],
};
