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
});

const name = computed(() => props.value?.name)

</script>

<template>
    <div
        :class="{'cursor-pointer text-blue-600 hover:underline': clickable}"
    >
        {{name}}
    </div>
</template>

<style scoped>

</style>
