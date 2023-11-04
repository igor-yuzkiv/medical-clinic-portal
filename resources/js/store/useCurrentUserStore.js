import {defineStore} from "pinia";
import {logoutRequest} from "@/api/usersApi.js";

export const useCurrentUserStore = defineStore('currentUser', {
    state  : () => ({
        userData: {
            id   : null,
            name : null,
            email: null,
            role : null,
        }
    }),
    getters: {
        getId() {
            return this.userData?.id
        },
        getName() {
            return this.userData?.name
        },
        getInitials() {
            return this.userData?.initials
        }
    },
    actions: {
        async logout() {
            await logoutRequest().catch(() => {});
            this.userData = null;
            localStorage.removeItem('token');
        },
        setCurrentUser(user) {
            this.userData = user;
        }
    }
})
