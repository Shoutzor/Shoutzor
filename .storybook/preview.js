import { app } from '@storybook/vue3';
import { BootstrapIconsPlugin  } from 'bootstrap-icons-vue';

app.use(BootstrapIconsPlugin);

export const parameters = {
    actions: { argTypesRegex: "^on[A-Z].*" },
    controls: {
        matchers: {
            color: /(background|color)$/i,
            date: /Date$/,
        },
    },
    backgrounds: {
        default: 'dark',
        values: [
            {
                name: 'dark',
                value: '#212121',
            },
            {
                name: 'light',
                value: '#f8f9fa',
            },
        ],
    },
};
