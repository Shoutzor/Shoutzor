import { Shoutzor } from './main';

export default {
    install: (app, options) => {
        let shoutzor = new Shoutzor(app);

        app.config.globalProperties.Shoutzor = shoutzor;
        shoutzor.initialize();
    }
}