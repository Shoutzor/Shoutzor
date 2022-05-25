const path = require('path');

module.exports = {
    stories: ["../stories/**/*.stories.mdx", "../stories/**/*.stories.@(js|jsx|ts|tsx)"],
    addons: ["@storybook/addon-links", "@storybook/addon-essentials"],
    framework: "@storybook/vue3",
    core: {
        builder: "webpack5"
    },
    webpackFinal: async (config, {configType}) => {
        config.module.rules.push({
            test: /\.scss$/,
            use: [
                'style-loader',
                'css-loader',
                {
                    loader: 'sass-loader',
                    options: {
                        additionalData: '@import "' + path.resolve(__dirname, '../resources/scss/app.scss') + '";'
                    }
                }
            ]
        });

        console.log(config.module.rules);

        config.resolve.extensions = ['.js', '.vue', '.json', '.scss', '.sass', '.css'];
        config.resolve.alias = {
            ...config.resolve.alias,
            '@components': path.resolve(__dirname, '../resources/components'),
            '@js': path.resolve(__dirname, '../resources/js'),
            '@scss': path.resolve(__dirname, '../resources/scss'),
            '@static': path.resolve(__dirname, '../resources/static')
        };

        return config;
    }
};
