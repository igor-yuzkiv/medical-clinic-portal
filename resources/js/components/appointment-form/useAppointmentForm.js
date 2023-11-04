import {reactive, ref} from "vue";
import {object} from "yup";
import {appointmentApi} from "@/api/appointmentApi.js";

export const formInitialValue = () => ({});

export const formValidationSchema = () => object({
    patient_id   : '',
    patient_name : '',
    patient_phone: '',
    service_name : '',
    date_time    : '',
});

export function useAppointmentForm() {
    const formValue = ref({})
    const formModalIsVisible = ref(false);

    async function validateForm(showError = true) {

    }

    async function createAppointment() {

    }

    async function updateAppointment() {
        console.log('updateAppointment')
    }

    async function loadAppointment(id) {
        const response = await appointmentApi
            .getById(id)
            .then(({data}) => data)
            .catch(console.error)

        console.log(response);
    }

    async function openAppointmentFormModal(id) {
        if (id) {
            await loadAppointment(id);
        }else {
            formValue.value = formInitialValue();
        }

        formModalIsVisible.value = true;
    }

    function closeAppointmentFormModal() {
        formModalIsVisible.value = false;
    }

    return {
        formValue,
        validateForm,
        createAppointment,
        updateAppointment,
        formModalIsVisible,
        openAppointmentFormModal,
        closeAppointmentFormModal,
    }
}
