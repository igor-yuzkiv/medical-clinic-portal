import router from '@/router';
import http from "@/plugins/http.js";
import store from '@/store';
import '@/style.css'
import toasity from "@/plugins/toasity.js";
import {i18n} from "@/plugins/i18n";


import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export function registerPlugins(app) {
    app.use(store)
    app.use(router)
    app.provide("http", http)
    app.use(i18n);
    app.component('VueDatePicker', VueDatePicker);
    toasity(app);
}
