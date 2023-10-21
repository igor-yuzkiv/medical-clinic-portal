<script setup>

import {Icon} from "@iconify/vue";
</script>

<template>
    <div class="absolute top-0 w-full  h-screen bg-indigo-100/70 z-40">
        <div class="flex flex-col items-center justify-center flex-grow h-screen">
            <Icon
                icon="fluent-mdl2:progress-ring-dots"
                class="w-56 h-56 mr-2 text-indigo-400 animate-spin"
            />
        </div>
    </div>
</template>

<style scoped>

</style>
