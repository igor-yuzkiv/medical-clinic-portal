export const HOME_ROUTE_NAME = "home";

export const ROUTES = {
    login: {
        name: "login",
        path: "login",
        component: () => import("@/views/auth/login/LoginView.vue")
    },

    home: {
        name: "home",
        path: "",
        component: () => import("@/views/home/HomeView.vue")
    },
}
