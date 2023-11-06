<script setup>
import AutocompleteField from "@/components/autocomplete-field/AutocompleteField.vue";
import {Input, Select} from "flowbite-vue";
import {SERVICES_OPTIONS} from "@/constants/enums.js";
import {uk} from 'date-fns/locale';
import {computed} from "vue";
import {DISPLAY_DATE_FORMAT, SERVER_DATE_FORMAT} from "@/constants/index.js";
import moment from "moment";
import {usePatients} from "@/composable/usePatients.js";
import {useCurrentUserStore} from "@/store/useCurrentUserStore.js";
import {vMaska} from "maska";

const emit = defineEmits(["update:modelValue"])
const props = defineProps({
    modelValue: {
        type   : Object,
        default: () => ({}),
    },
})

const currentUserStore = useCurrentUserStore();
const {filters, patients, loadPatents} = usePatients(true);

const dateTime = computed({
    get() {
        if (!props.modelValue['date_time']) return '';
        return moment(props.modelValue['date_time'], SERVER_DATE_FORMAT).toDate();
    },
    set(value) {
        emit('update:modelValue', {
            ...props.modelValue,
            date_time: moment(value).format(SERVER_DATE_FORMAT)
        });
    }
})

const isNewPatient = computed({
    get() {
        return props.modelValue['is_new_patient'] ?? false;
    },
    set(value) {
        emit('update:modelValue', {...props.modelValue, is_new_patient: value});
    }
})

const patientId = computed({
    get() {
        return props.modelValue['patient_id'] ?? '';
    },
    set(value) {
        emit('update:modelValue', {...props.modelValue, patient_id: value});
    }
})

function onFieldChange(field, e) {
    emit('update:modelValue', {...props.modelValue, [field]: e.target.value});
}

async function handleSearchPatient(search) {
    filters.value = [`doctor(${currentUserStore.getId})`, `search(keyword:${search})`];
    await loadPatents();
    return patients.value;
}
</script>

<template>
    <div class="flex flex-col py-2 px-4">
        <autocomplete-field
            v-if="!modelValue['is_new_patient']"
            :label="$t('patient')"
            v-model="patientId"
            :items="patients"
            item-key="id"
            item-label="name"
            :items-provider="handleSearchPatient"
            append-icon="icon-park:plus"
            @click:append="isNewPatient = true"
            required
            :placeholder="$t('select_patient')"
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
                :placeholder="$t('select_service')"
                :model-value="modelValue['service_type'] ?? ''"
                @change="onFieldChange('service_type', $event)"
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
                :format="DISPLAY_DATE_FORMAT"
                :enable-time-picker="false"
                v-model="dateTime"
                :placeholder="$t('enter_appointment_date')"
                auto-apply
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
