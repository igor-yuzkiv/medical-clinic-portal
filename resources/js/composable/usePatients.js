import {ref} from "vue";
import {patientApi} from "@/api/patientApi.js";

export function usePatients(paginate = true) {
    const patients = ref([]);
    const filters = ref([]);
    const pagination = ref({
        total       : 0,
        count       : 0,
        per_page    : 10,
        current_page: 1,
        total_pages : 1,
        links       : {}
    });

    async function loadPatents(page = null) {
        if (Number.isFinite(page)) {
            pagination.value.current_page = page;
        }

        const response = await patientApi.getList({
            query: {
                paginate: true,
                page    : pagination.value.current_page,
                per_page: pagination.value.per_page,
            },
            filters: filters.value,
        })
            .then(({data}) => data)
            .catch(console.error);


        if (Array.isArray(response?.data)) {
            patients.value = response.data;
        }

        if (response?.meta?.pagination) {
            pagination.value = response.meta.pagination;
        }
    }

    return {
        patients,
        pagination,
        filters,
        loadPatents
    }
}
