import "@/style.css";

import App from './App.vue'
import {createApp} from 'vue'
import {registerPlugins} from '@/plugins';

const app = createApp(App)
import {createPinia} from 'pinia'

const pinia = createPinia();
app.use(pinia);

registerPlugins(app);

app.mount('#app')
