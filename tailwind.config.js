const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.blade.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', 'Sarabun', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'rose': '#ecb7bf',
                'google': '#5F6368',
            },
        },
    },

    plugins: [require('daisyui'), require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
