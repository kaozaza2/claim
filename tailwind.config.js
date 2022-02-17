const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    // mode: 'jit',
    purge: (process.env.NODE_ENV === 'production') ? [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ] : false,

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', 'Sarabun', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('daisyui'), require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
