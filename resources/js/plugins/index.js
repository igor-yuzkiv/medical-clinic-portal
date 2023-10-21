import router from '@/router';
import http from "@/plugins/http.js";
import store from '@/store';
import datePicker from '@/plugins/datePicker.js';
import toasity from "@/plugins/toasity.js";
import {i18n} from "@/plugins/i18n";
import '@/style.css'

export function registerPlugins(app) {
    app.use(store)
    app.use(router)
    app.provide("http", http)
    app.use(i18n);
    datePicker(app);
    toasity(app);
}
