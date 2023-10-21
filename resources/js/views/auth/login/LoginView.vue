<script setup>
import {Icon} from "@iconify/vue";
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
                    type="password"
                    class="bg-indigo-100 shadow-sm border-none text-gray-900 rounded-xl focus:ring-indigo-500 block w-full pl-10 pr-2.5 py-2.5"
                    :placeholder="$t('password')"
                />
            </div>

            <button
                type="button"
                class="block w-full mt-7 p-2 bg-indigo-500 text-white uppercase font-semibold rounded-full hover:bg-indigo-600"
            >
                {{ $t("sign_in_now") }}
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
