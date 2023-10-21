<script setup>
import {computed} from "vue";
import {Select} from "flowbite-vue";

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

const label = computed(() => props.settings?.label ?? '')
const options = computed(() => {
    if (!props.settings?.options || !Array.isArray(props.settings?.options)) {
        console.warn('options must be an array')
        return [];
    }

    return props.settings.options.map(option => {
        if (typeof option === 'string') {
            return {
                value: option,
                name : option
            }
        }

        return option;
    })
})
const readonly = computed(() => Boolean(props.settings?.readonly))


function handleOnInput(e) {
    emit('update:modelValue', e.target.value)
}

</script>

<template>
    <div class="flex flex-col w-full">
        <Select
            :model-value="modelValue"
            @input="handleOnInput"
            :options="options"
            :label="label"
            :readonly="readonly"
        />
    </div>
</template>

<style scoped>

</style>
