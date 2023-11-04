<script setup>
import AutocompleteField from "@/components/autocomplete-field/AutocompleteField.vue";
import {Input, Select} from "flowbite-vue";
import {SERVICES_OPTIONS} from "@/constants/domain.js";
import {uk} from 'date-fns/locale';
import {computed} from "vue";
import {DATE_TIME_FORMAT} from "@/constants/domain.js";
import moment from "moment";

const emit = defineEmits(["update:modelValue"])
const props = defineProps({
    modelValue: {
        type   : Object,
        default: () => ({}),
    },
})

const dateTime = computed({
    get() {
        return props.modelValue['date_time'] ?? '';
    },
    set(value) {
        value = moment(value).format(DATE_TIME_FORMAT);
        const newModelValue = {...props.modelValue};
        newModelValue['date_time'] = value;
        emit('update:modelValue', newModelValue);
    }
})

const isNewPatient = computed({
    get() {
        return props.modelValue['is_new_patient'] ?? false;
    },
    set(value) {
        const newModelValue = {...props.modelValue};
        newModelValue['is_new_patient'] = value;
        emit('update:modelValue', newModelValue);
    }
})

function onFieldChange(field, e) {
    const value = e.target.value;
    const newModelValue = {...props.modelValue};
    newModelValue[field] = value;
    emit('update:modelValue', newModelValue);
}

</script>

<template>
    <div class="flex flex-col py-2 px-4">
        <h1 class="ml-1 mb-2 text-lg font-semibold">
            Створити новий запис
        </h1>

        <autocomplete-field
            v-if="!modelValue['is_new_patient']"
            required
            :label="$t('patient')"
            append-icon="icon-park:plus"
            @click:append="isNewPatient = true"
            :model-value="modelValue['patient_id'] ?? ''"
            @change="onFieldChange('patient_id', $event)"
        />

        <div v-if="modelValue['is_new_patient']">
            <div class="flex flex-col mt-3">
                <label class="font-medium text-sm">
                    <span class="text-red-500 font-semibold">*</span>
                    {{ $t('patient_name') }}
                </label>
                <Input
                    :model-value="modelValue['patient_name'] ?? ''"
                    @input="onFieldChange('patient_name', $event)"
                />
            </div>

            <div class="flex flex-col mt-3">
                <label class="font-medium text-sm">
                    <span class="text-red-500 font-semibold">*</span>
                    {{ $t('patient_phone') }}
                </label>
                <Input
                    :model-value="modelValue['patient_phone'] ?? ''"
                    @input="onFieldChange('patient_phone', $event)"
                />
            </div>
        </div>

        <div class="flex flex-col mt-3">
            <label class="font-medium text-sm">
                <span class="text-red-500 font-semibold">*</span>
                {{ $t('service') }}
            </label>
            <Select
                :options="Object.values(SERVICES_OPTIONS)"
                placeholder="Оберіть послугу"
                :model-value="modelValue['service_name'] ?? ''"
                @change="onFieldChange('service_name', $event)"
            />
        </div>

        <div class="flex flex-col mt-3">
            <label class="font-medium text-sm">
                <span class="text-red-500 font-semibold">*</span>
                {{ $t('date') }}
            </label>

            <VueDatePicker
                class="x__date-time-picker w-full mt-1"
                :cancelText="$t('cancel')"
                :selectText="$t('select')"
                :format-locale="uk"
                :enable-time-picker="false"
                v-model="dateTime"
            />
        </div>
    </div>

</template>

<style scoped>
.x__date-time-picker:deep(.dp__input_wrap input) {
    @apply rounded-lg py-2 bg-gray-50 border-gray-300 text-gray-700
}

.x__date-time-picker:deep(.dp__action_select) {
    @apply bg-blue-500 text-white
}
</style>
