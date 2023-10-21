<script setup>
import assetsPath from "@/constants/assetsPath.js";
</script>

<template>
    <section
        class="x__auth-layout relative flex flex-col flex-grow md:justify-center h-screen overflow-hidden bg-gradient-to-b from-indigo-100 to-java-50"
    >
        <div class="absolute top-0 -right-44">
            <svg class="w-[300px]" viewBox="0 0 1869 606" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="934.5" cy="-328.5" r="934.5" fill="#B3E5FC"/>
            </svg>
        </div>

        <div class="md:flex container mx-auto">
            <div class="flex items-center justify-center w-full text-center">
                <img class="w-5/6" :src="assetsPath.fullLogo" alt="full-logo"/>
            </div>

            <main class="flex flex-col w-full bg-white rounded-xl shadow-sm">
                <slot>
                    <router-view></router-view>
                </slot>
            </main>
        </div>
    </section>
</template>

<style scoped>

</style>
