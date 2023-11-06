<script setup>
import UserMenu from "@/layouts/default/parts/UserMenu.vue";

const appName = import.meta.env.VITE_APP_NAME;
import assetsPath from "@/constants/assetsPath.js";
</script>

<template>
    <section class="relative flex flex-col h-screen w-full overflow-hidden bg-gray-100 min-w-[350px]">
        <header class="flex items-center justify-between px-2 w-full p-2 bg-white shadow-sm">
            <div class="flex items-center gap-x-2">
                <img class="w-10" :src="assetsPath.logo" alt="full-logo"/>
                <div class="flex items-center gap-x-1">
                    <h1 class="font-semibold text-patina-600 text-xl uppercase">{{appName}}</h1>
                    <h1 class="font-semibold text-patina-700 text-xl uppercase">2021</h1>
                </div>
            </div>

            <user-menu/>
        </header>
        <main class="flex flex-col flex-grow overflow-hidden">
            <router-view></router-view>
        </main>
    </section>
</template>

<style scoped>

</style>
