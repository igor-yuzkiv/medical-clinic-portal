<script setup>
import {Button, Modal} from "flowbite-vue";
import {nextTick, onMounted, ref} from "vue";
import {appointmentApi} from "@/api/appointmentApi.js";
import AppointmentForm from "@/components/appointment-form/AppointmentForm.vue";
import AppointmentsTable from "@/components/appointments-table/AppointmentsTable.vue";
import {useStore} from "vuex";
import {SET_IS_LOADING} from "@/store/mutation-types.js";

const store = useStore();
const appointments = ref([]);
const apptFormDialog = ref({
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
    apptFormDialog.value = {
        id    : null,
        isOpen: false,
    };
    loadAppointments();
}

function handleOpenApptForm(appointment) {
    apptFormDialog.value = {
        id    : appointment?.id,
        isOpen: true,
    };
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

        <div class="flex flex-grow w-full bg-white rounded-xl shadow overflow-hidden">
            <appointments-table :items="appointments" @click:edit="handleOpenApptForm"/>
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
