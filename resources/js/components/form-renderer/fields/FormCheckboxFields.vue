<script setup>
import {computed} from "vue";
import {Checkbox} from "flowbite-vue";

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type   : Boolean,
        default: null
    },
    settings  : {
        type   : Object,
        default: () => ({})
    },
})

const label = computed(() => props.settings?.label ?? '')

function handleOnInput(e) {
    emit('update:modelValue', e.target.checked)
}

</script>

<template>
    <div class="flex flex-col w-full">
        <Checkbox
            class="w-full"
            :model-value="modelValue"
            @input="handleOnInput"
            :label="label"
        />
    </div>
</template>

<style scoped>

</style>
