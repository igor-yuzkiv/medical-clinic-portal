<script setup>
import {ref} from "vue";
import {useOnClickOutside} from "@/hooks/useOnClickOutside.js";
import {useStore} from "vuex";
import {useRouter} from "vue-router";
import {ROUTES} from "@/constants/navigation.js";

const store = useStore();
const router = useRouter();

const container = ref(null);
const isOpen = ref(false);
const user = {
    name    : "Ігор Юзьків",
    initials: 'ІЮ',
    email   : "iy@crmoz.com"
};

function handleLogout() {
    store.dispatch("logout");
    router.push({name: ROUTES.login.name});
}

useOnClickOutside(container, () => isOpen.value = false);
</script>

<template>
    <div class="relative" ref="container">
        <button
            type="button"
            class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden rounded-full shrink-0 text-gray-700 p-3 font-semibold text-md bg-gray-300 focus:ring-2 hover:ring-2 hover:ring-gray-400 focus:ring-gray-400"
            id="user-menu-button"
            aria-expanded="false"
            data-dropdown-toggle="user-dropdown"
            data-dropdown-placement="bottom"
            @click="isOpen=!isOpen"
        >
            <span>{{ user?.initials ?? 'UU' }}</span>
        </button>
        <!-- Dropdown menu -->
        <div
            class="z-50 absolute my-2 right-0 text-base list-none divide-y rounded-lg shadow bg-gray-700 divide-gray-600"
            id="user-dropdown"
            :class="{hidden: !isOpen}"
        >
            <div class="px-4 py-3">
                <span class="truncate block text-sm text-gray-100">{{ user.name }}</span>
            </div>

            <div class="divide-y divide-gray-600">
                <button
                    @click="handleLogout"
                    class="block w-full px-4 py-2 text-sm hover:bg-gray-00 text-gray-200 hover:text-white rounded-b-lg"
                >
                    {{ $t('sign_out_now') }}
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
