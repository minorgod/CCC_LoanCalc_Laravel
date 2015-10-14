var elixir = require('laravel-elixir');

var paths = {
    'bootstrap': 'vendor/bower_components/bootstrap-sass-official/assets/',
    'jquery':    'vendor/bower_components/jquery/dist/'
};


/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    //copy all components to their proper resource directories
    mix
        // Uncomment if you want to include your own copy of jquery/bootstrap instead of using the CDN
        .copy(paths.bootstrap + 'fonts/bootstrap', 'public/fonts')
        .copy(paths.jquery + "jquery.js", "resources/assets/js/jquery.js")
        .copy(paths.bootstrap + "javascripts/bootstrap.js","resources/assets/js/bootstrap.js")
        ;

    //compile our sass into css and save to public/css/all.css
    mix.sass(['app.scss'], 'public/css/all.css', {includePaths: [paths.bootstrap + 'stylesheets/']});

    //combine our scripts into the public/js/all.js file
    mix.scripts(['jquery.js','bootstrap.js','app.js'],'public/js/all.js');

    //now version our all.css and all.js files
    mix.version([
                "public/css/all.css",
                "public/js/all.js"
    ]);


    
});
