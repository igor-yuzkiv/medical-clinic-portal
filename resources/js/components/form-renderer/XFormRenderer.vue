<script setup>
import {FieldType} from "@/components/form-renderer/index.js";
import FormTextFields from "@/components/form-renderer/fields/FormTextFields.vue";
import FormSelectField from "@/components/form-renderer/fields/FormSelectField.vue";
import FormTextareaFields from "@/components/form-renderer/fields/FormTextareaFields.vue";
import FormCheckboxFields from "@/components/form-renderer/fields/FormCheckboxFields.vue";
import FormRadioField from "@/components/form-renderer/fields/FormRadioField.vue";
import FormDateTimeField from "@/components/form-renderer/fields/FormDateTimeField.vue";

const emit = defineEmits([
    'update:modelValue',
    'submit'
])

const props = defineProps({
    schema    : {
        type    : Object,
        required: true
    },
    modelValue: {
        type   : Object,
        default: () => ({})
    },
})


const fieldComponents = {
    [FieldType.text]    : FormTextFields,
    [FieldType.select]  : FormSelectField,
    [FieldType.textarea]: FormTextareaFields,
    [FieldType.checkbox]: FormCheckboxFields,
    [FieldType.radio]   : FormRadioField,
    [FieldType.dateTime]: FormDateTimeField,
}

function handleOnInput(fieldName, value) {
    const data = {
        ...props.modelValue,
        [fieldName]: value
    }
    emit('update:modelValue', data)
}

function fieldIsHidden(field) {
    return field?.hidden
}

</script>

<template>
    <div class="flex flex-col flex-grow gap-2">
        <div
            v-for="(field, filedName) in schema"
            :key="filedName"
        >
            <div
                v-show="!fieldIsHidden(field)"
            >
                <slot :name="`field:${filedName}`" v-bind="{field, handleOnInput, value: modelValue[filedName]}">
                    <component
                        :is="fieldComponents[field.type]"
                        :settings="field"
                        :modelValue="modelValue[filedName]"
                        @update:modelValue="handleOnInput(filedName, $event)"
                    />
                </slot>
            </div>
        </div>

        <slot></slot>
    </div>
</template>

<style scoped>

</style>
