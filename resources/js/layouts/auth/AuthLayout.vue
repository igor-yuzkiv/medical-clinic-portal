<script setup>
import assetsPath from "@/constants/assetsPath.js";
</script>

<template>
    <section
        class="x__auth-layout relative flex flex-col flex-grow md:justify-center h-screen overflow-hidden bg-gradient-to-tr from-atoll-50 to-white"
    >
        <div class="absolute top-0 -right-44">
            <svg class="w-[300px]" viewBox="0 0 1869 606" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="934.5" cy="-328.5" r="934.5" fill="#edfefd"/>
            </svg>
        </div>

        <img class="absolute top-2 right-4 w-12 h-12" :src="assetsPath.logo" alt="full-logo"/>

        <div class="flex items-center justify-center m-auto w-full md:w-3/4">
            <div class="hidden md:flex items-center justify-center w-full text-center">
                <img class="w-5/6" :src="assetsPath.fullLogo" alt="full-logo"/>
            </div>

            <main class="flex flex-col w-full bg-white shadow rounded-xl py-6 px-3 mx-1 md:mx-0">
                <slot>
                    <router-view></router-view>
                </slot>
            </main>
        </div>
    </section>
</template>

<style scoped>

</style>
