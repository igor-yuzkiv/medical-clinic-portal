import {createRouter, createWebHistory} from 'vue-router'
import {ROUTES} from '@/constants/navigation';
import DefaultLayout from "@/layouts/default/DefaultLayout.vue";
import AuthLayout from "@/layouts/auth/AuthLayout.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_APP_BASE_WEB_URI),
    routes : [
        {
            component: AuthLayout,
            path: "/auth",
            children : [
                ROUTES.login,
            ]
        },
        {
            path     : '/',
            component: DefaultLayout,
            children : [
                ROUTES.home,
            ]
        }
    ]
});

export default router;
