const mix = require('laravel-mix');
const glob = require('glob');

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

// mix.js('resources/js/app.js', 'public/js')
//     .react()
//     .sass('resources/sass/app.scss', 'public/css');

// globを使ってコンパイル対象をディレクトリ以下ワイルドカードで指定
glob.sync('resources/ts/**/*.tsx').map(function (file) {
    mix.ts(file, 'public/js')
});

glob.sync('resources/sass/**/*.scss').map(function (file) {
    mix.sass(file, 'public/css')
});

if (mix.inProduction()){
    mix.version();
}
