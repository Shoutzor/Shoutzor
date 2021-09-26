import { createApp } from "vue";
import router from "./router/app-installer";
import App from "@js/views/Installer";

//Create our Vue instance
const app = createApp(App);
app.use(router)
   .mount('#installer');
