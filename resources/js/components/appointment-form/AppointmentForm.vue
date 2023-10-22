<script setup>
import XFormRenderer from "@/components/form-renderer/XFormRenderer.vue";
import * as apptForm from "@/forms/appointmentForm.js";
import {Button, Input} from "flowbite-vue";
import {appointmentApi} from "@/api/appointmentApi.js";
import AutocompleteField from "@/components/autocomplete-field/AutocompleteField.vue";
import {usersApi} from "@/api/usersApi.js";
import {PATIENT_ROLE} from "@/constants/domain.js";
import {onMounted, ref} from "vue";

const emit = defineEmits(['submit'])
const props = defineProps({
    appointmentId: {
        type   : String,
        default: null,
    }
});

const isNewPatient = ref(false);
const formData = ref(apptForm.apptFromInitialValue())

async function loadAppointment() {
    if (!props.appointmentId) {
        return;
    }
    const response = await appointmentApi
        .getById(props.appointmentId)
        .then(({data}) => data)
        .catch(console.error)
    if (response?.id) {
        formData.value = response;
    }
}

async function handleSubmitted() {
    //todo: validate form

    const handleUpsert = async () => {
        return props.appointmentId
            ? appointmentApi.update(props.appointmentId, formData.value)
            : appointmentApi.create(formData.value)
    }

    //TODO: handle error
    await handleUpsert()
        .then(({data}) => {
            if (data?.id) {
                emit('submit', data);
            }
        })
        .catch(console.error)
}

async function handlePatientSearch(keyword = "") {
    const response = await usersApi.search(keyword, PATIENT_ROLE.value)
        .then(({data}) => data)
        .catch(console.error)
    return Array.isArray(response?.data) ? response.data : [];
}

function handleChangePatientId(id) {
    if (!id) {
        return;
    }
    formData.value.patient_id = id;
}

onMounted(loadAppointment);
</script>

<template>
    <x-form-renderer
        :schema="apptForm.apptFormSchema"
        v-model="formData"
    >
        <template #field:patient_id="{field}">
            <div class="flex flex-col w-full gap-y-1" v-if="isNewPatient">
                <Input
                    v-model="formData.patient_name"
                    :label="$t('patient_name')"
                />
                <Input
                    v-model="formData.patient_phone"
                    :label="$t('patient_phone')"
                />
            </div>
            <div v-else>
                <autocomplete-field
                    :label="field?.label"
                    item-key="id"
                    item-label="name"
                    :items-provider="handlePatientSearch"
                    append-icon="icon-park:plus"
                    :model-value="formData?.patient_id"
                    @update:modelValue="handleChangePatientId"
                    @click:append="isNewPatient = true"
                />
            </div>
        </template>
        <div class="flex flex-col items-end">
            <Button @click="handleSubmitted">{{ $t('save') }}</Button>
        </div>
    </x-form-renderer>
</template>

<style scoped>

</style>
