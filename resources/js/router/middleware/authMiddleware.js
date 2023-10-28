import store from "@/store/index.js";
import {fetchCurrentUser} from "@/api/usersApi.js";
import {ROUTES} from "@/constants/navigation.js";
import {SET_CURRENT_USER} from "@/store/mutation-types.js";

async function getCurrentUser() {
    return await fetchCurrentUser()
        .then(({data}) => data)
        .catch((e) => console.error(e))
}

async function logout(next) {
    await store.dispatch('logout');
    next({name: ROUTES.login.name});
}

export default async function (to, from, next) {
    const user = await getCurrentUser();
    if (!user?.id) {
        await logout(next)
        return;
    }
    store.commit(SET_CURRENT_USER, user)
    next();
}
