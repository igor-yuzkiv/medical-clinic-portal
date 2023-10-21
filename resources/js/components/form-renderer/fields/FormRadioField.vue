<script setup>
import {computed} from "vue";
import {Radio} from "flowbite-vue";

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

const options = computed(() => {
    if (!Array.isArray(props.settings?.options)) {
        console.warn('options must be an array')
        return [];
    }

    return props.settings.options.map(option => {
        if (typeof option === 'string') {
            return {
                value: option,
                name : option,
            }
        }

        return option;
    })
})

</script>

<template>
    <div class="flex flex-col gap-y-2">
        <Radio
            class="mt-1"
            :model-value="modelValue"
            @update:modelValue="$emit('update:modelValue', $event)"
            v-for="option in options"
            :key="option.value"
            :value="option.value"
        >
            <ion-icon v-if="option.icon" :name="option.icon"></ion-icon>
            {{ option.name }}
        </Radio>
    </div>
</template>

<style scoped>

</style>
