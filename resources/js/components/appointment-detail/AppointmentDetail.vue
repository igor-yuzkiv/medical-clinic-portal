<script setup>
import {useAppointmentDetail} from "@/composable/useAppointmentDetail.js";
import {computed, onMounted} from "vue";
import XAvatar from "@/components/avatar/XAvatar.vue";
import lodash from "lodash";
import EnumLabel from "@/components/enum-label/EnumLabel.vue";
import {SERVICES_OPTIONS} from "@/constants/enums.js";
import {Icon} from "@iconify/vue";
import {Badge} from "flowbite-vue";

const props = defineProps({
    appointmentId: {
        type    : [String, Number],
        required: true
    }
})

const {appointment, loadAppointment} = useAppointmentDetail();
const patientName = computed(() => lodash.get(appointment.value, "patient.name", ""));
const patientInitials = computed(() => lodash.get(appointment.value, "patient.initials", ""));
const patientPhone = computed(() => lodash.get(appointment.value, "patient.phone", ""));
const doctorName = computed(() => lodash.get(appointment.value, "doctor.name", ""));
const doctorPhone = computed(() => lodash.get(appointment.value, "doctor.phone", ""));

onMounted(() => {
    loadAppointment(props.appointmentId);
})

</script>

<template>
    <div class="flex flex-col p-2">
        <div class="flex items-center h-full justify-start">
            <div class="flex flex-col items-center">
                <x-avatar class="hidden md:inline-flex" circle size="lg">{{ patientInitials }}</x-avatar>
                <h1 class="mt-1 font-semibold text-blue-950">{{ patientName }}</h1>
                <div class="inline-flex items-center gap-x-1 text-sm text-gray-500">
                    <Icon icon="teenyicons:phone-solid"/>
                    <span>{{ patientPhone }}</span>
                </div>

                <Badge class="mt-3 p-1 w-full">{{ appointment.date }}</Badge>
                <enum-label
                    class="mt-1 p-1 w-full"
                    :options="Object.values(SERVICES_OPTIONS)"
                    :value="appointment.service_type"
                />
            </div>
            <div class="flex flex-col justify-start h-full mx-3 md:mx-5 mt-2">
                <div class="flex flex-col">
                    <h1 class="text-gray-800 font-semibold">{{ $t('doctor') }}:</h1>
                    <div class="flex flex-col ml-5">
                        <h1 class="text-blue-950 font-semibold text-xl">{{ doctorName }}</h1>

                        <div class="flex items-center gap-x-1">
                            <Icon class="text-gray-500 font-semibold text-sm" icon="teenyicons:phone-solid"/>
                            <a
                                :href="`tel:${doctorPhone}`"
                                class="text-blue-600 hover:underline cursor-pointer text-sm"
                            >
                                {{ doctorPhone }}
                            </a>
                        </div>
                    </div>
                </div>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
