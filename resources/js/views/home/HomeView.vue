<script setup>
import {Badge, Button} from "flowbite-vue";
import {inject, onMounted, ref} from "vue";
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
import {usePatientForm} from "@/components/patient-form/usePatientForm.js";
import PatientForm from "@/components/patient-form/PatientForm.vue";
import {i18n} from "@/plugins/i18n";

const toast = inject('toast');
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

const {
    patientFormValue,
    loadPatientById,
    validatePatientForm,
    createPatient,
    updatePatient
} = usePatientForm();

const patientFormModalIsOpen = ref(false);

async function openPatientFormModal(id = null) {
    if (userStore.isPatient) {
        return;
    }

    if (id) {
        const patient = await loadPatientById(id);
        if (!patient) {
            toast.error(i18n.global.t("something_went_wrong"))
            return;
        }
    }
    patientFormModalIsOpen.value = true;
}

function closePatientFormModal() {
    patientFormModalIsOpen.value = false;
}

async function onClickSavePatient() {
    const validated = await validatePatientForm();
    if (!validated) {
        return;
    }

    const handleSave = async () => {
        if (patientFormValue.value?.id) {
            return await updatePatient(patientFormValue.value.id, validated);
        } else {
            return await createPatient(validated);
        }
    }

    rootStore.toggleLoader(true)
    await handleSave()
        .then(({data}) => {
            if (!data?.id) {
                toast.success(i18n.global.t("saved_successfully"))
                closePatientFormModal();
                loadAppointments();
                return;
            }

            toast.error(i18n.global.t("something_went_wrong"))
        })
        .catch(() => toast.error(i18n.global.t("something_went_wrong")))
        .finally(() => rootStore.toggleLoader(false))
}

async function onClickSaveAppointment() {
    rootStore.toggleLoader(true);

    const handleSave = async () => {
        return selectedAppointment.value?.id
            ? await updateAppointment(selectedAppointment.value.id)
            : await createAppointment()
    }

    rootStore.toggleLoader(true);
    await handleSave()
        .then(({data}) => {
            if (!data?.id) {
                toast.success(i18n.global.t("saved_successfully"))
                closeAppointmentModal();
                loadAppointments();
                return;
            }

            toast.error(i18n.global.t("something_went_wrong"))
        })
        .catch(() => toast.error(i18n.global.t("something_went_wrong")))
        .finally(() => rootStore.toggleLoader(false))
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
                            <div
                                class="flex items-center gap-x-1 font-semibold"
                                :class="{
                                    'x_change-content' : userStore.isDoctor,
                                }"
                                @click.stop="openPatientFormModal(item.patient_id)"
                            >
                                <h1 class="text-gray-500">#{{ item.id }}</h1>
                                <h1 class="text-xl text-blue-500 custor-pointer hover:underline">
                                    {{ item.patient_name }}
                                </h1>
                                <Icon class="x_change-target text-xl text-blue-500" icon="mdi:pencil"/>
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
            v-model="appointmentModalIsVisible"
            @close="closeAppointmentModal"
            :card-class="{
                'h-auto p-2 max-w-[96%]' : true,
                'w-auto lg:w-3/6 xl:w-2/6': userStore.isDoctor,
                'w-auto': userStore.isPatient,
            }"
            overlay
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

        <x-modal
            v-model="patientFormModalIsOpen"
            @close="closePatientFormModal"
            :card-class="{
                'h-auto p-2 max-w-[96%]' : true,
                'w-auto lg:w-3/6 xl:w-2/6': userStore.isDoctor,
                'w-auto': userStore.isPatient,
            }"
            overlay
        >
            <div class="flex flex-col">
                <h1 class="ml-5 my-2 text-lg font-semibold text-blue-950">
                    {{ $t(patientFormValue?.id ? 'edit_patient' : 'create_patient') }}
                </h1>

                <patient-form v-model="patientFormValue"/>

                <div class="flex items-center justify-between mt-3 pt-2 border-t">
                    <Button outline @click="closePatientFormModal">
                        {{ $t('cancel') }}
                    </Button>
                    <Button @click="onClickSavePatient">
                        {{ $t('save') }}
                    </Button>
                </div>
            </div>

        </x-modal>
    </teleport>
</template>

<style scoped>

</style>
