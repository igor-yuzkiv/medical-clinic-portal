<script>
import {Icon} from "@iconify/vue";
import {defineComponent} from "vue";
import axios from "axios";
import {fetchCurrentUser, loginRequest} from "@/api/usersApi.js";
import {SET_AUTH_TOKEN, SET_CURRENT_USER, SET_IS_LOADING} from "@/store/mutation-types.js";
import {HOME_ROUTE_NAME} from "@/constants/navigation.js";

export default defineComponent({
    inject    : ['toast'],
    components: {
        Icon
    },
    data() {
        return {
            showPassword: false,
            formData    : {
                login   : '',
                password: '',
            }
        }
    },
    async mounted() {
        const user = await fetchCurrentUser()
            .then((response) => response?.data ?? {})
            .catch(() => {
            })

        if (user?.id) {
            this.$store.commit(SET_CURRENT_USER, user)
            this.$router.push({name: HOME_ROUTE_NAME})
        }
    },
    methods: {
        async handleLogin() {
            if (!this.formData.login || !this.formData.password) {
                this.toast.error(this.$t('login_and_password_required'))
                return
            }

            this.$store.commit(SET_IS_LOADING, true)
            const response = await axios.get("/sanctum/csrf-cookie")
                .then(() => loginRequest(this.formData))
                .then((response) => response?.data ?? {})
                .catch(() => this.toast.error(this.$t('invalid_credentials')))
                .finally(() => {
                    this.$store.commit(SET_IS_LOADING, false)
                })

            const {user, token} = response ?? {};
            if (!token || !user?.id) {
                return;
            }
            this.$store.commit(SET_CURRENT_USER, user)
            this.$store.commit(SET_AUTH_TOKEN, token)
            localStorage.setItem('token', token)
            this.$router.push({name: HOME_ROUTE_NAME})
        }
    }
})

</script>

<template>
    <div class="flex flex-col flex-grow items-center">
        <div class="flex flex-none flex-col items-center justify-center text-center">
            <h1 class="text-2xl font-semibold uppercase">{{ $t("sign_in") }}</h1>
            <div class="text-sm text-gray-500 mt-2">Lorem Ipsum is simply dummy text of the printing and typesetting
                industry.
            </div>
        </div>

        <div class="flex flex-col items-center w-full md:w-3/4 mt-5">
            <div class="relative flex items-center w-full">
                <Icon
                    icon="ri:user-line"
                    class="absolute left-2 text-2xl text-indigo-700"
                />
                <input
                    type="text"
                    v-model="formData.login"
                    class="bg-indigo-100 shadow-sm border-none text-gray-900 rounded-xl focus:ring-indigo-500 block w-full pl-10 pr-2.5 py-2.5"
                    :placeholder="$t('login')"
                />
            </div>

            <div class="relative flex items-center w-full mt-3">
                <Icon
                    icon="mdi:password-outline"
                    class="absolute left-2 text-2xl text-indigo-700"
                />
                <input
                    v-model="formData.password"
                    :type="showPassword ? 'text' : 'password'"
                    class="bg-indigo-100 shadow-sm border-none text-gray-900 rounded-xl focus:ring-indigo-500 block w-full px-10 py-2.5"
                    :placeholder="$t('password')"
                />

                <Icon
                    :icon="showPassword ? 'mdi:eye-off-outline' : 'mdi:eye-outline'"
                    class="absolute right-2 text-2xl text-indigo-700 cursor-pointer"
                    @click="showPassword = !showPassword"
                />
            </div>

            <button
                type="button"
                class="block w-full mt-7 py-3 px-2 bg-indigo-500 text-white uppercase font-semibold rounded-full hover:bg-indigo-600"
                @click="handleLogin"
            >
                {{ $t("sign_in_now") }}
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
