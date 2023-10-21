<script setup>
import UserMenu from "@/layouts/default/parts/UserMenu.vue";

const appName = import.meta.env.VITE_APP_NAME;
import assetsPath from "@/constants/assetsPath.js";
</script>

<template>
    <section class="relative flex flex-col h-screen w-full overflow-hidden bg-gray-100">
        <header class="flex items-center justify-between px-2 w-full p-2 bg-white shadow-sm">
            <div class="flex items-center gap-x-3">
                <img class="w-10" :src="assetsPath.logo" alt="full-logo"/>
                <h1 class="font-semibold text-indigo-600 text-xl">{{appName}}</h1>
            </div>

            <div>
                <user-menu></user-menu>
            </div>
        </header>
        <main class="flex flex-col flex-grow overflow-hidden">
            <router-view></router-view>
        </main>
    </section>
</template>

<style scoped>

</style>
