const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a"}
              },
              
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                // sans: ['Inter var', ...defaultTheme.fontFamily.sans],
           
            },
        },
    },

    variants: {
        background:['responsive', 'fucos', 'hover', 'active'],
        fontSize:['responsive', 'hover'],
    },

    plugins: [
        require('@tailwindcss/line-clamp'),
        require('@tailwindcss/forms'), 
        require('@tailwindcss/typography')],  
};
