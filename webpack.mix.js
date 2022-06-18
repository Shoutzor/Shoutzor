const mix = require('laravel-mix');
require('laravel-mix-purgecss');

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json', '.scss', '.sass', '.css'],
        alias: {
            '@components': __dirname + '/resources/components',
            '@js': __dirname + '/resources/js',
            '@models': __dirname + '/resources/js/models',
            '@scss': __dirname + '/resources/scss',
            '@static': __dirname + '/resources/static',
            '@graphql': __dirname + '/resources/js/graphql',
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
mix.js('resources/js/app.js', 'public/js')
    .vue({
        globalStyles: __dirname + '/resources/scss/_theme.scss',
    })
    .sass('resources/scss/app.scss', 'public/css')
    .purgeCss({
        enabled: true,
        // Some of our CSS is not properly detected, thus requiring whitelisting.
        safelist: [
            /^dropdown/,
            /^alert/,
            /data-bs-popper/, //Some bootstrap classes are generated with this data tag
            /^ps/, // vue-perfect-scrollbar classes
            /^router-link/ //All router-link classes are generated with JS
        ]
    });

mix.copy('resources/static/images/shoutzor-logo-large.png', 'public/images');
mix.copy('resources/static/images/appicon', 'public/images/appicon');

if (mix.inProduction()) {
    mix.version();
}
