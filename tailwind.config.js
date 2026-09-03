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
            colors: {
                navy: '#0B1F3A',
                'navy-2': '#122B4E',
                orange: '#E8720C',
                'orange-dark': '#C75F06',
                yellow: '#F2B705',
                paper: '#F7F5F0',
                ink: '#14202F',
                muted: '#5A6B80',
                line: '#E3E0D8',
            },
            fontFamily: {
                display: ['Space Grotesk', 'sans-serif'],
                body: ['IBM Plex Sans', 'sans-serif'],
                sans: ['IBM Plex Sans', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
