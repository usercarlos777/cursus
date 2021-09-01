const mix = require("laravel-mix");

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

mix
  .js("resources/js/app.js", "public/js")
  .vue()
  .sass("resources/sass/app.scss", "public/css")
  .sass(
    "resources/sass/frontend/instructor-dashboard.scss",
    "public/frontend/css"
  )
  .sass("resources/sass/frontend/style.scss", "public/frontend/css")
  .sass(
    "resources/sass/frontend/vertical-responsive-menu.scss",
    "public/frontend/css"
  )
  .sass("resources/sass/frontend/night-mode.scss", "public/frontend/css")
  .sass("resources/sass/admin/style.scss", "public/admin/assets/css")
  .options({
    processCssUrls: false,
  });
