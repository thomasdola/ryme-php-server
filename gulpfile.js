var elixir = require('laravel-elixir');
require('laravel-elixir-vueify');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');
    mix.browserify('dashboard.js');
    mix.browserify('users.js');
    mix.browserify('user-profile.js');
    mix.browserify('companies.js');
    mix.browserify('artists.js');
    mix.browserify('admin.js');
    mix.browserify('categories.js');
});
