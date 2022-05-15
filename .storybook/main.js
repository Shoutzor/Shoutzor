const path = require('path');

module.exports = {
    "stories": ["../stories/**/*.stories.mdx", "../stories/**/*.stories.@(js|jsx|ts|tsx)"],
    "addons": ["@storybook/addon-links", "@storybook/addon-essentials"],
    "framework": "@storybook/vue3",
    core: {
        builder: "webpack5"
    },
    webpackFinal: async (config, { configType }) => {
        config.resolve.extensions = ['.js', '.vue', '.json', '.scss', '.sass', '.css'];
        config.resolve.alias = {
            ...config.resolve.alias,
            vue: "@vue/compat",
            '@js': path.resolve(__dirname, '/resources/js'),
            '@scss': path.resolve(__dirname, '/resources/scss'),
            '@static': path.resolve(__dirname, '/resources/static')
        };

        return config;
    }
};
