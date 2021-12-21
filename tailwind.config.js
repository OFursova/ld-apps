const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            maxWidth: {
                '1/4': '25%',
                '1/2': '50%',
                '3/4': '75%',
                '4xl': '56rem',
            },
            colors: {
                'rose-600': '#e11d48',
                'purple': '#3f3cbb',
                'midnight': '#121063',
                'metal': '#565584',
                'tahiti': '#3ab7bf',
                'silver': '#evebff',
                'bubble-gum': '#ff77e9',
                'bermuda': '#78dcca',
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
