import {ref} from "vue";
import {appointmentApi} from "@/api/appointmentApi.js";

export function useAppointments() {
    const appointments = ref([]);
    const pagination = ref({
        total       : 0,
        count       : 0,
        per_page    : 10,
        current_page: 1,
        total_pages : 1,
        links       : {}
    });

    async function loadAppointments(page = null) {
        if (Number.isFinite(page) && page > 0) {
            pagination.value.current_page = page;
        }

        const {data, meta} = await appointmentApi
            .getList({
                query: {
                    paginate: true,
                    per_page: pagination.value.per_page ?? 10,
                    page    : pagination.value.current_page ?? 1,
                }
            })
            .then(({data}) => data)
            .catch(console.error)

        if (data && data?.length) {
            appointments.value = data;
        }

        if (meta ?? meta?.pagination) {
            pagination.value = meta.pagination;
        }
    }

    return {
        appointments,
        pagination,
        loadAppointments
    };
}
