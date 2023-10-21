<script setup>
import {Button, Modal} from "flowbite-vue";
import {inject, onBeforeMount, ref} from "vue";
import {appointmentApi} from "@/api/appointmentApi.js";
import AppointmentForm from "@/components/appointment-form/AppointmentForm.vue";
import UpcomingAppointments from "@/components/upcoming-appointments/UpcomingAppointments.vue";
import AppointmentsTable from "@/components/appointments-table/AppointmentsTable.vue";
import {apptFromInitialValue} from "@/forms/appointmentForm.js";

const toast = inject('toast');
const appointments = ref([]);
const upcomingAppointments = ref([]);
const apptFormDialog = ref(false);
const apptFormData = ref(apptFromInitialValue());

async function loadAppointments() {
    const response = await appointmentApi
        .getList()
        .then(({data}) => data)

    if (Array.isArray(response?.data)) {
        appointments.value = response.data;
    }
}

async function handleOnApptSubmitted() {
    //todo: validate form

    const handleUpsert = async () => {
        return apptFormData.value?.id
            ? appointmentApi.update(apptFormData.value.id, apptFormData.value)
            : appointmentApi.create(apptFormData.value)
    }

    await handleUpsert()
        .then(({data}) => {
            if (data?.id) {
                apptFormDialog.value = false;
                loadAppointments();
                return;
            }
            //todo: handle error
        })
        .catch(console.error)

}

function handleOpenApptForm(appointment) {
    if (!appointment?.id) {
        apptFormDialog.value = true;
        apptFormData.value = apptFromInitialValue();
        return;
    }

    apptFormDialog.value = true;
    apptFormData.value = appointment;
}

onBeforeMount(() => {
    loadAppointments();
})
</script>

<template>
    <div class="flex flex-col flex-grow p-2 overflow-hidden">
        <div class="flex flex-none items-center justify-end bg-white rounded-xl p-2 shadow">
            <Button @click="handleOpenApptForm">{{ $t("create_appointment") }}</Button>
        </div>

        <div class="flex flex-grow mt-2 gap-x-3 overflow-hidden">
            <div class="flex w-full bg-white rounded-xl shadow overflow-hidden">
                <appointments-table
                    :items="appointments"
                    @click:edit="handleOpenApptForm"
                />
            </div>
            <div class="hidden md:flex flex-col w-1/4 bg-white rounded-xl shadow p-1 overflow-hidden">
                <div class="mx-2 font-semibold text-lg text-gray-500">{{ $t('scheduled_appointments') }}</div>
                <div class="flex flex-col flex-grow overflow-y-auto mt-2 pl-2">
                    <UpcomingAppointments/>
                </div>
            </div>
        </div>
    </div>

    <teleport to="#x__modals">
        <Modal
            v-if="apptFormDialog"
            @close="apptFormDialog = false"
        >

            <template #header>
                <div class="flex items-center text-lg">
                    {{ $t('appointment') }}
                </div>
            </template>
            <template #body>
                <appointment-form
                    v-model="apptFormData"
                    @submit="handleOnApptSubmitted"
                    hide-submit-button
                />
            </template>
            <template #footer>
                <div class="flex items-center justify-between">
                    <Button outline @click="apptFormDialog = false">{{ $t('cancel') }}</Button>
                    <Button @click="handleOnApptSubmitted">{{ $t('save') }}</Button>
                </div>
            </template>
        </Modal>
    </teleport>
</template>

<style scoped>

</style>
