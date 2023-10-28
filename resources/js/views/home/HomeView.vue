<script setup>
import {Button, Modal} from "flowbite-vue";
import {nextTick, onMounted, ref} from "vue";
import {appointmentApi} from "@/api/appointmentApi.js";
import AppointmentForm from "@/components/appointment-form/AppointmentForm.vue";
import AppointmentsTable from "@/components/appointments-table/AppointmentsTable.vue";
import {useStore} from "vuex";
import {SET_IS_LOADING} from "@/store/mutation-types.js";
import {useAppointments} from "@/hooks/useAppointments.js";
import XPagination from "@/components/pagination/XPagination.vue";


const store = useStore();

const {
    appointments,
    loadAppointments,
    pagination,
} = useAppointments();

const apptFormDialog = ref({
    isOpen: false,
    id    : null,
});

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

        <div class="flex flex-col flex-grow overflow-hidden bg-white rounded-xl shadow p-1 mt-2">
            <div class="flex flex-grow w-full overflow-hidden">
                <appointments-table :items="appointments" @click:edit="handleOpenApptForm"/>
            </div>
            <div class="flex flex-none justify-center w-full">
                <x-pagination
                    :current-page="pagination.current_page"
                    :total-pages="pagination.total_pages"
                    @page-changed="loadAppointments($event)"
                />
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
