<script setup>
import {Badge, Button} from "flowbite-vue";
import {onMounted} from "vue";
import AppointmentForm from "@/components/appointment-form/AppointmentForm.vue";
import {useAppointments} from "@/composable/useAppointments.js";
import XPagination from "@/components/pagination/XPagination.vue";
import {SERVICES_OPTIONS} from "@/constants/enums.js";
import {Icon} from "@iconify/vue";
import EnumLabel from "@/components/enum-label/EnumLabel.vue";
import {useRootStore} from "@/store/useRootStore.js";
import {useAppointmentForm} from "@/components/appointment-form/useAppointmentForm.js";
import XModal from "@/components/modal/XModal.vue";
import {appointmentApi} from "@/api/appointmentApi.js";
import {useCurrentUserStore} from "@/store/useCurrentUserStore.js";
import AppointmentDetail from "@/components/appointment-detail/AppointmentDetail.vue";
import XAvatar from "@/components/avatar/XAvatar.vue";

const rootStore = useRootStore();
const userStore = useCurrentUserStore();
const {appointments, loadAppointments, pagination} = useAppointments();
const {
    selectedAppointment,
    createAppointment,
    updateAppointment,
    appointmentModalIsVisible,
    openAppointmentModal,
    closeAppointmentModal
} = useAppointmentForm();

async function onClickSaveAppointment() {
    rootStore.toggleLoader(true);

    const response = selectedAppointment.value?.id
        ? await updateAppointment(selectedAppointment.value.id)
        : await createAppointment()

    if (!response) {
        rootStore.toggleLoader(false);
        return;
    }

    await loadAppointments(1);
    closeAppointmentModal();
    rootStore.toggleLoader(false);
}

async function onClickAppointment(appointment) {
    const response = await appointmentApi
        .getById(appointment.id)
        .then(({data}) => data)
        .catch(console.error)

    if (!response?.id) {
        return
    }

    selectedAppointment.value = response;
    openAppointmentModal();
}

function onClickDownloadResults() {
    alert('...')
}

onMounted(async () => {
    rootStore.toggleLoader(true);
    await loadAppointments().finally(() => rootStore.toggleLoader(false))
})
</script>

<template>
    <div class="flex flex-col flex-grow p-2 overflow-hidden">

        <div class="flex flex-none justify-between w-full">
            <div>
                <x-pagination
                    v-if="appointments?.length"
                    v-bind="{...pagination}"
                    @change:page="loadAppointments"
                />
            </div>

            <div>
                <Button
                    v-if="userStore.isDoctor"
                    class="shadow-sm"
                    @click="openAppointmentModal"
                >
                    {{ $t('create_appointment') }}
                    <template #suffix>
                        <Icon class="text-xl" icon="icon-park-outline:plus"/>
                    </template>
                </Button>
            </div>
        </div>

        <div class="flex flex-col flex-grow relative overflow-auto mt-2">
            <ul class="space-y-2" v-if="appointments?.length">
                <li
                    v-for="item in appointments"
                    :key="item.id"
                    @click="onClickAppointment(item)"
                >
                    <div
                        class="flex relative w-full bg-white rounded-xl shadow-sm px-2 pt-2 pb-10 md:pb-2 cursor-pointer"
                    >
                        <div class="absolute bottom-1 right-0">
                            <button
                                type="button"
                                class="mr-1 inline-flex gap-x-1 shrink-0 grow-0 text-sm font-medium bg-blue-600 text-white px-1 py-1 sm:px-3 rounded-full sm:rounded-lg"
                                :title="$t('download_results')"
                                @click.stop="onClickDownloadResults(item)"
                            >
                                <span>{{ $t('download_results') }}</span>
                                <Icon class="w-5 h-5" icon="line-md:download-loop"/>
                            </button>
                        </div>

                        <div class="flex flex-col items-center ml-1 sm:ml-3">
                            <x-avatar size="xl" circle class="mb-2">{{ item.patient_name_initials }}</x-avatar>
                            <enum-label
                                class="w-full"
                                :value="item.service_type"
                                :options="Object.values(SERVICES_OPTIONS)"
                            />

                            <Badge class="mt-1 p-1 w-full truncate">{{ item.date }}</Badge>
                        </div>

                        <div class="flex flex-col ml-1 sm:ml-3 h-full">
                            <div class="flex items-center gap-x-1 font-semibold">
                                <h1 class="text-gray-500">#{{ item.id }}</h1>
                                <h1 class="text-xl text-blue-500 custor-pointer hover:underline">{{ item.patient_name }}</h1>
                            </div>

                            <div class="flex flex-col">
                                <div
                                    class="flex text-lg items-center gap-x-1 px-1"
                                    v-if="userStore.isDoctor"
                                >
                                    <Icon class="text-gray-500 font-semibold text-sm" icon="teenyicons:phone-solid"/>
                                    <a
                                        :href="`tel:${item.patient_phone}`"
                                        class="text-blue-500 hover:underline cursor-pointer text-sm"
                                    >
                                        {{ item.patient_phone }}
                                    </a>
                                </div>

                                <div class="flex items-center px-1 mt-3 font-medium">
                                    <span class="text-gray-600 text-sm">{{ $t('doctor') }}:</span>
                                    <span class="ml-1 text-blue-950 text-sm">{{ item.doctor_name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            <!--Records not fount-->
            <div
                v-else
                class="flex flex-col flex-grow items-center justify-center text-gray-400 text-center cursor-pointer"
                @click="openAppointmentModal"
            >
                <Icon icon="cil:sad" class="w-64 h-64"/>
                <h1 class="text-3xl">{{ $t('no_records_found') }}, <br/> {{ $t('do_create_one') }}</h1>
            </div>
        </div>
    </div>

    <!--Modals-->
    <teleport to="#x__modals">
        <x-modal
            v-model="appointmentModalIsVisible" overlay
            @close="closeAppointmentModal"
            :card-class="{
                'h-auto p-2 max-w-[96%]' : true,
                'w-auto lg:w-3/6 xl:w-2/6': userStore.isDoctor,
                'w-auto': userStore.isPatient,
            }"
        >
            <div class="flex flex-col" v-if="userStore.isDoctor">
                <h1 class="ml-5 my-2 text-lg font-semibold text-blue-950">
                    {{ $t(selectedAppointment?.id ? 'edit_appointment' : 'create_appointment') }}
                </h1>

                <appointment-form v-model="selectedAppointment"/>
                <div class="flex items-center justify-between mt-3 pt-2 border-t">
                    <Button outline @click="closeAppointmentModal">
                        {{ $t('cancel') }}
                    </Button>
                    <Button @click="onClickSaveAppointment">
                        {{ $t('save') }}
                    </Button>
                </div>
            </div>
            <div class="flex flex-col" v-if="userStore.isPatient">
                <appointment-detail :appointment-id="selectedAppointment.id">
                    <div class="flex items-center justify-center w-full h-full">
                        <Button @click.stop="onClickDownloadResults(selectedAppointment)">
                            <template #prefix>
                                <Icon class="text-xl" icon="line-md:download-loop"/>
                            </template>
                            {{ $t('download_results') }}
                        </Button>
                    </div>
                </appointment-detail>
            </div>
        </x-modal>
    </teleport>
</template>

<style scoped>

</style>
