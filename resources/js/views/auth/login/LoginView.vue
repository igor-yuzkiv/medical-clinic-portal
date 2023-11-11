<script>
import {Icon} from "@iconify/vue";
import {defineComponent} from "vue";
import axios from "axios";
import {loginRequest} from "@/api/usersApi.js";
import {HOME_ROUTE_NAME} from "@/constants/navigation.js";
import {useRootStore} from "@/store/useRootStore.js";
import {useCurrentUserStore} from "@/store/useCurrentUserStore.js";

export default defineComponent({
    inject    : ['toast'],
    components: {Icon},
    data() {
        return {
            showPassword: false,
            formData    : {
                login   : '',
                password: '',
            }
        }
    },
    setup() {
        const rootStore = useRootStore();
        const currentUserStore = useCurrentUserStore();
        return {rootStore, currentUserStore};
    },
    methods: {
        async onClickLogin() {
            if (!this.formData.login || !this.formData.password) {
                this.toast.error(this.$t('login_and_password_required'))
                return
            }

            this.rootStore.toggleLoader(true)

            const response = await axios.get("/sanctum/csrf-cookie")
                .then(() => loginRequest(this.formData))
                .then((response) => response?.data ?? {})
                .catch(() => this.toast.error(this.$t('invalid_credentials')))
                .finally(() => this.rootStore.toggleLoader(false))

            const {user, token} = response ?? {};
            if (!token || !user?.id) {
                return;
            }

            this.currentUserStore.setCurrentUser(user);
            localStorage.setItem('token', token)
            this.$router.push({name: HOME_ROUTE_NAME})
        }
    }
})

</script>

<template>
    <div class="flex flex-col flex-grow items-center">
        <div class="flex flex-none flex-col items-center justify-center text-center">
            <h1 class="text-jelly-bean-800 text-2xl font-semibold uppercase">{{ $t("sign_in") }}</h1>
        </div>

        <div class="flex flex-col items-center w-full md:w-3/4 mt-5 lg:mt-8">
            <div class="relative flex items-center w-full">
                <Icon
                    icon="ri:user-line"
                    class="absolute left-2 text-2xl text-jelly-bean-700"
                />
                <input
                    type="text"
                    v-model="formData.login"
                    class="bg-jelly-bean-50 shadow-sm border-none text-jelly-bean-700 rounded-xl focus:ring-jelly-bean-500 block w-full pl-10 pr-2.5 py-2.5"
                    :placeholder="$t('login')"
                />
            </div>

            <div class="relative flex items-center w-full mt-3">
                <Icon
                    icon="mdi:password-outline"
                    class="absolute left-2 text-2xl text-jelly-bean-700"
                />
                <input
                    v-model="formData.password"
                    :type="showPassword ? 'text' : 'password'"
                    class="bg-jelly-bean-50 shadow-sm border-none text-jelly-bean-700 rounded-xl focus:ring-jelly-bean-500 block w-full pl-10 pr-2.5 py-2.5"
                    :placeholder="$t('password')"
                />

                <Icon
                    :icon="showPassword ? 'mdi:eye-off-outline' : 'mdi:eye-outline'"
                    class="absolute right-2 text-2xl text-jelly-bean-700"
                    @click="showPassword = !showPassword"
                />
            </div>

            <button
                type="button"
                class="block w-full mt-7 py-3 px-2 bg-patina-500 text-white uppercase font-semibold rounded-2xl hover:bg-jelly-bean-600"
                @click="onClickLogin"
            >
                {{ $t("sign_in_now") }}
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
