var elixir = require('laravel-elixir');

require('laravel-elixir-livereload');

elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix.sass()
        .browserify('app.js')
        .copy('resources/assets/img', 'public/img')
        .livereload();
});