import {ApiResource} from "@/api/apiResource.js";
import http from "@/plugins/http.js";

const appointmentApi = new ApiResource('/appointments');

appointmentApi.availableIncludes = {
    doctor : "doctor",
    patient: "patient",
}

appointmentApi.fetchUpcoming = function (includes = []) {
    return appointmentApi.getList({
        includes,
        filters: ['upcoming'],
        query  : {
            paginate: false,
            orderBy : 'date_time',
            order   : "asc"
        }
    });
}

export {
    appointmentApi,
}
