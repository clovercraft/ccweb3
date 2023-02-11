const mix = require('laravel-mix')

mix
    .copyDirectory('resources/images', 'public/img')
    .autoload({
        jquery: ['$', 'window.jQuery']
    })
    .js('resources/scripts/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/components.scss', 'public/css')
    .sourceMaps();
