<script setup>
import XFormRenderer from "@/components/form-renderer/XFormRenderer.vue";
import {apptFormSchema} from "@/forms/appointmentForm.js";
import {Button} from "flowbite-vue";

const emit = defineEmits([
    'update:modelValue',
    'submit'
])

const props = defineProps({
    modelValue      : {
        type   : Object,
        default: () => ({}),
    },
    hideSubmitButton: {
        type   : Boolean,
        default: false,
    },
});

</script>

<template>
    <x-form-renderer
        :schema="apptFormSchema"
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
    >
        <div class="flex flex-col items-end" v-if="!hideSubmitButton">
            <Button @click="$emit('submit', modelValue)">{{ $t('save') }}</Button>
        </div>
    </x-form-renderer>
</template>

<style scoped>

</style>
