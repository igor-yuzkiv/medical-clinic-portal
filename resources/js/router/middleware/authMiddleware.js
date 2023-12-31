import {fetchCurrentUser} from "@/api/usersApi.js";
import {ROUTES} from "@/constants/navigation.js";
import {useCurrentUserStore} from "@/store/useCurrentUserStore.js";

export default async function (to, from, next) {
    const currentUserStore = useCurrentUserStore();
    const response = await fetchCurrentUser()
        .then(({data}) => data)
        .catch(() => null);

    if (!response?.id) {
        await currentUserStore.logout();
        next({name: ROUTES.login.name});
        return;
    }
    currentUserStore.setCurrentUser(response)
    next();
}
