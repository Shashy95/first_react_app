const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .react() // This enables React support
   .postCss('resources/css/app.css', 'public/css', [
      require('tailwindcss'),
  ]);