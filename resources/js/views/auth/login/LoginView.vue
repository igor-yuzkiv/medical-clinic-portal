<script setup>

import {Button, Input} from "flowbite-vue";
import XTextField from "@/components/input/text-field/XTextField.vue";
</script>

<template>
    <div class="flex flex-col flex-grow items-center m-2">
        <h1 class="text-2xl font-semibold mt-3">{{$t("sign_in")}}</h1>

        <x-text-field :placeholder="$t('login')" rounded></x-text-field>

    </div>
</template>

<style scoped>

</style>
