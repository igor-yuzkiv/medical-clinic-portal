import {defineStore} from "pinia";
import {logoutRequest} from "@/api/usersApi.js";
import {DOCTOR_ROLE, PATIENT_ROLE} from "@/constants/enums.js";

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
        },
        isDoctor() {
            return this.userData?.role === DOCTOR_ROLE.value;
        },
        isPatient() {
            return this.userData?.role === PATIENT_ROLE.value;
        }
    },
    actions: {
        async logout() {
            await logoutRequest().catch(() => {
            });
            this.userData = null;
            localStorage.removeItem('token');
        },
        setCurrentUser(user) {
            this.userData = user;
        }
    }
})
