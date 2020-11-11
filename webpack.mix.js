const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/static/js')
    .sass('resources/sass/app.scss', 'public/static/css');

mix.scripts([
    'resources/js/util.js',
    'resources/js/validate.js',
    'resources/js/api-token.js',
    'resources/js/budget.js',
    'resources/js/edit-category.js',
    'resources/js/save-transaction.js',
    'resources/js/sort-table.js',
    'resources/js/transactions.js',
    'resources/js/validator.js'
], 'public/static/js/utility.js');
