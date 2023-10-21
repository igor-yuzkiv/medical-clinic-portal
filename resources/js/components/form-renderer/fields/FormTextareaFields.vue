<script setup>
import {computed} from "vue";
import {Textarea} from "flowbite-vue";

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
const placeholder = computed(() => props.settings?.placeholder ?? '')
const rows = computed(() => props.settings?.rows ?? 3)

function handleOnInput(e) {
    emit('update:modelValue', e.target.value)
}

</script>

<template>
    <div class="flex flex-col w-full">
        <Textarea
            class="w-full"
            :model-value="modelValue"
            @input="handleOnInput"
            :placeholder="placeholder"
            :rows="rows"
            :label="label"
        >
            <template #footer>

            </template>
        </Textarea>
    </div>
</template>

<style scoped>

</style>
