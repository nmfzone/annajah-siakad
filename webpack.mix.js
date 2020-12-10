const mix = require('laravel-mix')
require('./webpack.config')
require('laravel-mix-tailwind')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
  .js('resources/js/dashboard.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/dashboard.scss', 'public/css')
  .tailwind('./tailwind.config.js')
  .browserSync({
    proxy: process.env.APP_PROTOCOL + '://' + process.env.APP_HOST,
    port: 3000
  })

mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts/', 'public/fonts/vendor/font-awesome')
mix.copy('node_modules/tinymce/themes', 'public/vendor/tinymce/themes')
mix.copy('node_modules/tinymce/icons', 'public/vendor/tinymce/icons')
mix.copy('node_modules/tinymce/skins', 'public/vendor/tinymce/skins')
mix.copy('node_modules/tinymce/plugins', 'public/vendor/tinymce/plugins')

if (mix.inProduction()) {
  mix.version()
}
