const mix = require('laravel-mix')
require('./webpack.config')
require('laravel-mix-tailwind')
require('laravel-mix-browser-sync-multi')

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

// ====== UNCOMMENT BELOW ON THE FIRST TIME ONLY ======
// mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts/', 'public/vendor/font-awesome')
//   .copy('node_modules/tinymce/themes', 'public/vendor/tinymce/themes')
//   .copy('node_modules/tinymce/icons', 'public/vendor/tinymce/icons')
//   .copy('node_modules/tinymce/skins', 'public/vendor/tinymce/skins')
//   .copy('node_modules/tinymce/plugins', 'public/vendor/tinymce/plugins')
//   .copy('node_modules/overlayscrollbars/css/OverlayScrollbars.css', 'resources/sass/vendor/overlayscrollbars/OverlayScrollbars.scss')
//   .copy('node_modules/icheck-bootstrap/icheck-bootstrap.css', 'resources/sass/vendor/icheck-bootstrap/icheck-bootstrap.scss')
//   .copy('vendor/almasaeed2010/adminlte/dist/css/adminlte.css', 'resources/sass/vendor/almasaeed2010/adminlte.scss')
//   .copy('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css', 'resources/sass/vendor/datatables.net-bs4/dataTables.bootstrap4.scss')
//   .copy('node_modules/datatables.net-buttons-bs4/css/buttons.bootstrap4.css', 'resources/sass/vendor/datatables.net-buttons-bs4/buttons.bootstrap4.scss')
//   .copy('node_modules/datatables.net-responsive-bs4/css/responsive.bootstrap4.css', 'resources/sass/vendor/datatables.net-responsive-bs4/responsive.bootstrap4.scss')


mix.js('resources/js/app.js', 'public/js').vue()
  .js('resources/js/dashboard.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/dashboard.scss', 'public/css')
  .tailwind('./tailwind.config.js')
  .browserSyncMulti([
    {
      proxy: process.env.APP_PROTOCOL + '://' + process.env.APP_HOST,
      port: 3000
    },
    {
      proxy: process.env.APP_PROTOCOL + '://smpit.' + process.env.APP_HOST,
      port: 3001
    }
  ])

if (mix.inProduction()) {
  mix.version()
}
