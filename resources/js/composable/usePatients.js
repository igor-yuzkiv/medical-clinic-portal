import {ref} from "vue";

export function usePatients() {
    const patients = ref([]);
    const pagination = ref({
        total       : 0,
        count       : 0,
        per_page    : 10,
        current_page: 1,
        total_pages : 1,
        links       : {}
    });
    const filters = ref([]);

    return {
        patients,
        pagination,
        filters,
    }
}
