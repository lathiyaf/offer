const mix = require('laravel-mix');
mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/crawlapps-cli-offer.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
mix.styles(["resources/css/style.css"],'public/css/app.css');
mix.version();
