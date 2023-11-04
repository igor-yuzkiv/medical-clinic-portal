import {createRouter, createWebHistory} from 'vue-router'
import {ROUTES} from '@/constants/navigation';
import DefaultLayout from "@/layouts/default/DefaultLayout.vue";
import AuthLayout from "@/layouts/auth/AuthLayout.vue";
import authMiddleware from "@/router/middleware/authMiddleware.js";
import redirectIfLoggedIn from "@/router/middleware/redirectIfLoggedIn.js";

const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_APP_BASE_WEB_URI),
    routes : [
        {
            component: AuthLayout,
            path: "/auth",
            children : [
                ROUTES.login,
            ],
            beforeEnter: [redirectIfLoggedIn],
        },
        {
            path     : '/',
            component: DefaultLayout,
            children : [
                ROUTES.home,
            ],
            beforeEnter: [authMiddleware],
        }
    ]
});

export default router;
