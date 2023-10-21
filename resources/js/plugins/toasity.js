import Vue3Toasity, {toast} from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

export default function (app) {
    app.use(Vue3Toasity, {position: toast.POSITION.TOP_RIGHT})
    app.provide("toast", toast)
}
