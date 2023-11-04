<script setup>
import {Badge, Button} from "flowbite-vue";
import {onMounted} from "vue";
import AppointmentForm from "@/components/appointment-form/AppointmentForm.vue";
import {useAppointments} from "@/composable/useAppointments.js";
import XPagination from "@/components/pagination/XPagination.vue";
import {SERVICES_OPTIONS} from "@/constants/domain.js";
import {Icon} from "@iconify/vue";
import EnumLabel from "@/components/enum-label/EnumLabel.vue";
import {useRootStore} from "@/store/useRootStore.js";
import {useAppointmentForm} from "@/components/appointment-form/useAppointmentForm.js";
import DisplayField from "@/components/display-field/DisplayField.vue";
import XModal from "@/components/modal/XModal.vue";
import {appointmentApi} from "@/api/appointmentApi.js";

const rootStore = useRootStore();
const {appointments, loadAppointments, pagination} = useAppointments();

const {
    formValue,
    createAppointment,
    updateAppointment,
    formModalIsVisible,
    openAppointmentFormModal,
    closeAppointmentFormModal
} = useAppointmentForm();

async function onClickSaveAppointment() {
    rootStore.toggleLoader(true);
    if (formValue?.value.id) {
        await updateAppointment(formValue.value.id);
    } else {
        await createAppointment();
    }
    await loadAppointments(1);
    closeAppointmentFormModal();
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

    formValue.value = response;
    openAppointmentFormModal();
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
                <Button class="shadow-sm" @click="openAppointmentFormModal">
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
                    <div class="flex relative w-full items-center bg-white rounded-xl shadow-sm p-2 cursor-pointer">
                        <div class="absolute top-1 right-0">
                            <div class="flex flex-col md:flex-row md:items-center">
                                <enum-label
                                    :value="item.service_name"
                                    :options="Object.values(SERVICES_OPTIONS)"
                                />
                                <Badge class="mt-1 md:mt-0">{{ item.date }}</Badge>
                            </div>
                        </div>

                        <div
                            class="inline-flex shrink-0 grow-0 text-white text-lg items-center justify-center font-semibold shadow-md rounded-full bg-gradient-to-tl from-indigo-400 via-indigo-500 to-indigo-600 w-8 h-8 lg:w-10 lg:h-10"
                        >
                            {{ item.patient_name_initials }}
                        </div>

                        <div class="flex flex-col items-start ml-3">
                            <h1 class="text-xl font-semibold text-blue-950">{{ item.patient_name }}</h1>
                            <div class="mt-1 flex flex-col md:flex-row md:items-center md:divide-x">
                                <display-field
                                    variant="tiny"
                                    :label="$t('patient_phone')"
                                    :value="item.patient_phone"
                                    class="px-1"
                                />
                                <display-field
                                    variant="tiny"
                                    :label="$t('doctor')"
                                    :value="item.doctor_name"
                                    class="px-1"
                                />
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            <!--Records not fount-->
            <div
                v-else
                class="flex flex-col flex-grow items-center justify-center text-gray-400 text-center cursor-pointer"
                @click="openAppointmentFormModal"
            >
                <Icon icon="cil:sad" class="w-64 h-64"/>
                <h1 class="text-3xl">{{ $t('no_records_found') }}, <br/> {{ $t('do_create_one') }}</h1>
            </div>
        </div>
    </div>

    <!--Modals-->
    <teleport to="#x__modals">
        <x-modal
            v-model="formModalIsVisible" overlay
            @close="closeAppointmentFormModal"
            card-class="w-auto lg:w-3/6 xl:w-2/6 p-2 h-auto"
        >
            <div class="flex flex-col transition-all duration-250">
                <h1 class="ml-5 my-2 text-lg font-semibold text-blue-950">
                    {{ $t(formValue?.id ? 'edit_appointment' : 'create_appointment') }}
                </h1>

                <appointment-form v-model="formValue"/>
                <div class="flex items-center justify-between mt-3 pt-2 border-t">
                    <Button outline @click="closeAppointmentFormModal">
                        {{ $t('cancel') }}
                    </Button>
                    <Button @click="onClickSaveAppointment">
                        {{ $t('save') }}
                    </Button>
                </div>
            </div>
        </x-modal>
    </teleport>
</template>

<style scoped>

</style>
