import {ref} from "vue";
import {appointmentApi} from "@/api/appointmentApi.js";

export function useAppointmentDetail() {
    const appointment = ref({});

    async function loadAppointment(id) {
        const response = await appointmentApi
            .getById(id, [
                appointmentApi.availableIncludes.patient,
                appointmentApi.availableIncludes.doctor
            ])
            .then(({data}) => data)
            .catch(console.error)

        console.log(response);
        if (response) {
            appointment.value = response;
        }
    }

    return {
        appointment,
        loadAppointment
    }
}
