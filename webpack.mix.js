const mix = require('laravel-mix');

/**
 * load webpack.env file
 */
require('dotenv').config({path: 'webpack.env'});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/admin/app.js', 'public/js/admin')
    .js("resources/js/jquery-ui.min.js", "public/js/admin");

mix.sass('resources/sass/admin/main.scss', 'public/css/admin')
  .options({ processCssUrls: false });

// basic
mix.js('resources/js/root.js', 'public/js');

mix.copy('node_modules/font-awesome/fonts', 'public/fonts/vendor/font-awesome');

if (mix.inProduction()) {
  mix.version();
}

mix.extract([
  'lodash',
  'axios',
  'vue',
], 'public/js/vendor.js')
  .autoload({ jquery: ['$', 'jQuery', 'window.jQuery'] });
