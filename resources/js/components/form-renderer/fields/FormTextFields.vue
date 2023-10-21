<script setup>
import {computed} from "vue";
import {Input} from "flowbite-vue";

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type   : [String, Number],
        default: null
    },
    settings  : {
        type   : Object,
        default: () => ({})
    },
})

const type = computed(() => props.settings?.inputType ?? 'text')
const label = computed(() => props.settings?.label ?? '')
const placeholder = computed(() => props.settings?.placeholder ?? '')
const readonly = computed(() => Boolean(props.settings?.readonly))

function handleOnInput(e) {
    emit('update:modelValue', e.target.value)
}

</script>

<template>
    <div class="flex flex-col w-full">
        <Input
            :type="type"
            class="w-full"
            :model-value="modelValue"
            @input="handleOnInput"
            :placeholder="placeholder"
            :label="label"
            :required="readonly"
        />
    </div>
</template>

<style scoped>

</style>
