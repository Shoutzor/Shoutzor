const mix = require('laravel-mix');

mix.webpackConfig({
    module: {
        rules: [
            {
                test:  /\.css$/i,
                use : [{
                    loader: 'css-loader',
                }],
            },
        ],
    },
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            'vue$': 'vue/dist/vue.esm.js',
            '@': __dirname + '/resources/js'
        },
    },
})

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

mix.sass('resources/sass/app.scss', 'public/css')
    .js('resources/js/app.js', 'public/js')
    .options({
        globalVueStyles: __dirname + '/resources/sass/_variables.scss'
    });

if (mix.inProduction()) {
    mix.version();
}
