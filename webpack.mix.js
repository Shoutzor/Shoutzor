const mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json', '.scss', '.sass', '.css'],
        alias: {
            '@components': __dirname + '/resources/components',
            '@js': __dirname + '/resources/js',
            '@models': __dirname + '/resources/js/models',
            '@scss': __dirname + '/resources/scss',
            '@static': __dirname + '/resources/static'
        },
        fallback: {
            "stream": require.resolve("stream-browserify")
        }
    }
});

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
mix.sass('resources/scss/app.scss', 'public/css')
    .js('resources/js/app.js', 'public/js')
    .vue({
        globalStyles: __dirname + '/resources/scss/app.scss',
    });

/*
mix.sass('resources/scss/app-installer.scss', 'public/css')
    .js('resources/js/app-installer.js', 'public/js')
    .vue({
        globalStyles: __dirname + '/resources/scss/app.scss'
    });*/

mix.copy('resources/static/images/shoutzor-logo-large.png', 'public/images');
mix.copy('resources/static/images/appicon', 'public/images/appicon');

if(mix.inProduction()) {
    mix.version();
}
