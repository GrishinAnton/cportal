let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js').version();

mix.sass('resources/assets/scss/app.scss', 'public/css').sourceMaps().version()

mix.browserSync({
  proxy: "cportal.loc",
  notify: false
});


mix.webpackConfig({
  output: {
    publicPath: '/',
    chunkFilename: 'js/[name].js'
  }
});