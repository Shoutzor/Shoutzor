import {
    configureCompat,
    createApp
} from "vue";
import { BootstrapIconsPlugin  } from 'bootstrap-icons-vue';
import router from "./router/app-installer";
import App from "@js/views/Installer";

// use @vue/compat new render API
configureCompat({ RENDER_FUNCTION: false });

//Create our Vue instance
const app = createApp(App);
app.use(router)
   .use(BootstrapIconsPlugin)
   .mount('#installer');
