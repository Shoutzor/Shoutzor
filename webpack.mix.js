const mix = require('laravel-mix');

mix.webpackConfig({
    module: {
        rules: [{
            test: /\.css$/i,
            use: [{
                loader: 'css-loader'
            }]
        }]
    },
    resolve: {
        extensions: ['.js', '.vue', '.json', '.scss', '.sass', '.css'],
        alias: {
            'vue$': 'vue/dist/vue.esm.js',
            '@js': __dirname + '/resources/js',
            '@scss': __dirname + '/resources/scss',
            '@static': __dirname + '/resources/static'
        }
    }
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

mix.sass('resources/scss/app.scss', 'public/css')
    .js('resources/js/app.js', 'public/js')
    .options({
        globalVueStyles: __dirname + '/resources/scss/_variables.scss'
    });

mix.copy('resources/static/images/shoutzor-logo-large.png', 'public/images');
mix.copy('resources/static/images/appicon', 'public/images/appicon');

if(mix.inProduction()) {
    mix.version();
}
