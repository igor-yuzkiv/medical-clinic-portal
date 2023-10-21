import {FieldType} from "@/components/form-renderer/index.js";
import {SERVICES_OPTIONS} from "@/constants/domain.js";

export const apptFromInitialValue = () => ({
    patient_id   : '',
    patient_name : '',
    patient_phone: '',
    service_name : '',
    date_time    : '',
})

export const apptFormSchema = {
    patient_id   : {
        type    : FieldType.text,
        label   : "Пацієнта",
        required: true,
        hidden  : true,
    },
    patient_name : {
        type       : FieldType.text,
        label      : "ПІБ пацієнта",
        required   : true,
        placeholder: "Введіть ПІБ пацієнта",
    },
    patient_phone: {
        type       : FieldType.text,
        label      : "Телефон пацієнта",
        required   : true,
        placeholder: "Введіть телефон пацієнта",
    },
    service_name : {
        type       : FieldType.select,
        label      : "Послуга",
        required   : true,
        placeholder: "Виберіть послугу",
        options    : Object.values(SERVICES_OPTIONS),
    },
    date_time    : {
        type       : FieldType.dateTime,
        label      : "Дата та час",
        required   : true,
        placeholder: "Виберіть дату та час",
    }
}
