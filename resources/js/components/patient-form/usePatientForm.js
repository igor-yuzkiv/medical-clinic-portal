import {inject, ref} from "vue";
import {patientApi} from "@/api/patientApi.js";
import * as Yup from "yup";
import {i18n} from "@/plugins/i18n";

export const patientFormInitialState = () => ({
    id   : null,
    name : '',
    phone: null,
})

export const patientFormValidationSchema = () => Yup.object({
    name : Yup.string().required(i18n.global.t('patient_name_is_required')),
    phone: Yup.string().required(i18n.global.t('patient_phone_is_required')).matches(/^\d{12}$/, i18n.global.t('phone_is_invalid')),
});

export function usePatientForm() {
    const patientFormValue = ref(patientFormInitialState());
    const toast = inject("toast");

    async function validatePatientForm() {
        return await patientFormValidationSchema()
            .validate(patientFormValue.value, {abortEarly: true})
            .catch(({message}) => {
                toast.error(message);
            })
    }

    async function loadPatientById(id) {
        const response = await patientApi.getById(id)
            .then(({data}) => data)
            .catch(console.log)

        if (response) {
            patientFormValue.value = response;
            return response;
        }
    }

    async function createPatient(data) {
        const response = await patientApi.create(data)
            .then(({data}) => data)
            .catch(console.log)

        if (response) {
            patientFormValue.value = response;
            return response;
        }
    }

    async function updatePatient(id, data) {
        const response = await patientApi.update(id, data)
            .then(({data}) => data)
            .catch(console.log)

        if (response) {
            patientFormValue.value = response;
            return response;
        }
    }

    return {
        patientFormValue,
        loadPatientById,
        createPatient,
        validatePatientForm,
        updatePatient,
    }
}
