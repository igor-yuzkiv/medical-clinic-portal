<script setup>
import {computed} from "vue";

const props = defineProps({
    value: {
        type   : Object,
        default: () => ({}),
    },
    clickable: {
        type   : Boolean,
        default: false,
    },
    showPhone: {
        type   : Boolean,
        default: false,
    },
});

const name = computed(() => props.value?.name)
const phone = computed(() => props.value?.phone)

</script>

<template>
    <div class="flex flex-col">
        <div :class="{'cursor-pointer text-blue-600 hover:underline': clickable}">
            {{name}}
        </div>
        <div v-if="showPhone && phone" class="text-sm text-gray-500">
            {{phone}}
        </div>

        <slot></slot>
    </div>
</template>

<style scoped>

</style>
