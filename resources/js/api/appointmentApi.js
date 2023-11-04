import {ApiResource} from "@/api/api.js";

const appointmentApi = new ApiResource('/appointments');

appointmentApi.availableIncludes = {
    doctor : "doctor",
    patient: "patient",
}

export {
    appointmentApi,
}
