import {inject, ref} from "vue";
import * as Yup from "yup";
import {i18n} from "@/plugins/i18n";
import {appointmentApi} from "@/api/appointmentApi.js";

export const formInitialValue = () => ({
    id            : null,
    patient_id    : null,
    patient_name  : '',
    patient_phone : '',
    service_type  : '',
    date_time     : '',
    is_new_patient: false,
});

export const formValidationSchema = () => Yup.object({
    is_new_patient: Yup.boolean(),
    patient_id    : Yup.string()
        .when('is_new_patient', {
            is       : false,
            then     : (schema) => schema.required(i18n.global.t('patient_is_required')),
            otherwise: (schema) => schema.nullable()
        }),
    patient_name  : Yup.string()
        .when('is_new_patient', {
            is       : true,
            then     : (schema) => schema.required(i18n.global.t('patient_name_is_required')),
            otherwise: (schema) => schema.nullable()
        }),
    patient_phone : Yup.string()
        .when('is_new_patient', {
            is       : true,
            then     : (schema) => schema.required(i18n.global.t('patient_phone_is_required')).matches(/^\d{12}$/, i18n.global.t('phone_is_invalid')),
            otherwise: (schema) => schema.nullable()
        }),
    service_type  : Yup.string().required(i18n.global.t('service_is_required')),
    date_time     : Yup.string().required(i18n.global.t('date_is_required')),
});

export function useAppointmentForm() {
    const selectedAppointment = ref(formInitialValue())
    const appointmentModalIsVisible = ref(false);
    const toast = inject("toast");

    async function validateForm() {
        return await formValidationSchema()
            .validate(selectedAppointment.value, {abortEarly: true})
            .catch(({message}) => {
                toast.error(message);
            })
    }

    async function createAppointment() {
        const data = await validateForm();
        if (!data) {
            return;
        }
        return await appointmentApi
            .create(data)
            .then(({data}) => data)
            .catch(() => {
                toast.error(i18n.global.t("something_went_wrong"))
            })
    }

    async function updateAppointment(id) {
        const data = await validateForm();
        if (!data) {
            return;
        }
        return await appointmentApi
            .update(id, data)
            .then(({data}) => data)
            .catch(() => {
                toast.error(i18n.global.t("something_went_wrong"))
            })
    }

    function openAppointmentModal() {
        appointmentModalIsVisible.value = true;
    }

    function closeAppointmentModal() {
        selectedAppointment.value = formInitialValue();
        appointmentModalIsVisible.value = false;
    }

    return {
        selectedAppointment,
        validateForm,
        createAppointment,
        updateAppointment,
        appointmentModalIsVisible,
        openAppointmentModal,
        closeAppointmentModal,
    }
}
