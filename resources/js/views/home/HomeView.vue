<script setup>
import {Button, Modal} from "flowbite-vue";
import {nextTick, onMounted, reactive, ref} from "vue";
import {appointmentApi} from "@/api/appointmentApi.js";
import AppointmentForm from "@/components/appointment-form/AppointmentForm.vue";
import UpcomingAppointments from "@/components/upcoming-appointments/UpcomingAppointments.vue";
import AppointmentsTable from "@/components/appointments-table/AppointmentsTable.vue";
import {useStore} from "vuex";
import {SET_IS_LOADING} from "@/store/mutation-types.js";

const store = useStore();

const appointments = ref([]);
const apptFormDialog = reactive({
    isOpen: false,
    id    : null,
});

async function loadAppointments() {
    const response = await appointmentApi
        .getList()
        .then(({data}) => data)

    if (Array.isArray(response?.data)) {
        appointments.value = response.data;
    }
}

function handleOnApptSubmitted() {
    apptFormDialog.isOpen = false;
    apptFormDialog.id = null;
    loadAppointments();
}

function handleOpenApptForm(appointment) {
    apptFormDialog.isOpen = true;
    apptFormDialog.id = appointment?.id;
}

onMounted(async () => {
    store.commit(SET_IS_LOADING, true)
    await loadAppointments();
    nextTick(() => {
        store.commit(SET_IS_LOADING, false)
    })
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
                    <upcoming-appointments/>
                </div>
            </div>
        </div>
    </div>

    <!--Modals-->
    <teleport to="#x__modals">
        <Modal v-if="apptFormDialog.isOpen" @close="apptFormDialog.isOpen = false">
            <template #header>
                <div class="flex items-center text-lg">
                    {{ $t('appointment') }}
                </div>
            </template>
            <template #body>
                <appointment-form
                    :appointment-id="apptFormDialog.id"
                    @submit="handleOnApptSubmitted"
                />
            </template>
        </Modal>
    </teleport>
</template>

<style scoped>

</style>
