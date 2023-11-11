<script setup>
import {Input} from "flowbite-vue";
import {vMaska} from "maska";

const emit = defineEmits(["update:modelValue", "submit"])
const props = defineProps({
    modelValue: {
        type   : Object,
        default: () => ({}),
    },
})

function onFieldChange(field, e) {
    emit('update:modelValue', {...props.modelValue, [field]: e.target.value});
}

</script>

<template>
    <div class="flex flex-col">
        <div class="flex flex-col mt-3">
            <label class="font-medium text-sm">
                <span class="text-red-500 font-semibold">*</span>
                {{ $t('patient_name') }}
            </label>
            <Input
                :model-value="modelValue['name'] ?? ''"
                @input="onFieldChange('name', $event)"
                :placeholder="$t('enter_patient_name')"
            />
        </div>

        <div class="flex flex-col mt-3">
            <label class="font-medium text-sm">
                <span class="text-red-500 font-semibold">*</span>
                {{ $t('patient_phone') }}
            </label>
            <Input
                v-maska
                data-maska="38##########"
                placeholder="380999999999"
                :model-value="modelValue['phone'] ?? ''"
                @input="onFieldChange('phone', $event)"
            />
        </div>
    </div>
</template>

<style scoped>

</style>
