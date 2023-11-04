import {useCurrentUserStore} from "@/store/useCurrentUserStore.js";
import {fetchCurrentUser} from "@/api/usersApi.js";
import {ROUTES} from "@/constants/navigation.js";

export default async function (to, from, next) {
    const currentUserStore = useCurrentUserStore();
    const response = await fetchCurrentUser()
        .then(({data}) => data)
        .catch(() => null);

    if (response?.id) {
        currentUserStore.setCurrentUser(response)
        next({name: ROUTES.home.name});
        return;
    }

    next();
}
