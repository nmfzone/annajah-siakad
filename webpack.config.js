const mix = require('laravel-mix')
const path = require('path')
const root = path.resolve(__dirname)

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
      '@vendor': `${root}/vendor`,
      '@root': `${root}/resources/js`,
      '@components': `${root}/resources/js/components`,
      '@mixins': `${root}/resources/js/mixins`,
      '@images': `${root}/resources/images`,
    }
  }
}

mix.webpackConfig(webpackConfig)

module.exports = webpackConfig
