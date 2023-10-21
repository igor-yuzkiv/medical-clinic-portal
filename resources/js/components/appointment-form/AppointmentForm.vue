<script setup>
import XFormRenderer from "@/components/form-renderer/XFormRenderer.vue";
import {apptFormSchema} from "@/forms/appointmentForm.js";
import {Button} from "flowbite-vue";
import {appointmentApi} from "@/api/appointmentApi.js";

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

async function handleSubmitted() {
    //todo: validate form

    const handleUpsert = async () => {
        return props.modelValue?.id
            ? appointmentApi.update(props.modelValue.id, props.modelValue)
            : appointmentApi.create(props.modelValue)
    }

    //TODO: handle error
    await handleUpsert()
        .then(({data}) => {
            if (data?.id) {
                emit('submit', data);
                return;
            }

        })
        .catch(console.error)
}
</script>

<template>
    <x-form-renderer
        :schema="apptFormSchema"
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
    >
        <!--        <template #field:patient_id>
                       TODO: add patient search
                </template>-->
        <div class="flex flex-col items-end" v-if="!hideSubmitButton">
            <Button @click="handleSubmitted">{{ $t('save') }}</Button>
        </div>
    </x-form-renderer>
</template>

<style scoped>

</style>
