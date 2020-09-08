const mix = require('laravel-mix');
const root = path.resolve(__dirname);

/*
 |--------------------------------------------------------------------------
 | Extended Mix Configuration
 |--------------------------------------------------------------------------
 |
 | Here we define our custom Configuration.
 |
 */

const webpackConfig = {
  resolve: {
    symlinks: false,
    alias: {
      '@root': `${root}/resources/js`,
      '@mixins': `${root}/resources/js/mixins`,
      '@images': `${root}/resources/images`,
    }
  }
};

mix.webpackConfig(webpackConfig);

module.exports = webpackConfig;
