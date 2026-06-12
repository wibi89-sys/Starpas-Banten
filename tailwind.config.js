import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                kanwil: {
                    blue: '#0B2B5E',
                    'blue-light': '#1E3A8A',
                    gold: '#D97706',
                    'gold-light': '#F59E0B',
                }
            },
        },
    },

    plugins: [forms],
};
