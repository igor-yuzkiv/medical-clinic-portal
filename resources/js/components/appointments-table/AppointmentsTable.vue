<script setup>

import {SERVICES_OPTIONS} from "@/constants/domain.js";
import EnumLabel from "@/components/enum-label/EnumLabel.vue";

defineEmits(['click:edit'])
defineProps({
    items: {
        type   : Array,
        default: () => []
    }
})

</script>

<template>
    <div class="relative w-full overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" v-if="items?.length">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    {{ $t("patient") }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ $t("doctor") }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ $t("date") }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ $t('service') }}
                </th>
                <th scope="col" class="px-6 py-3">

                </th>
            </tr>
            </thead>
            <tbody>
            <tr
                class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
                v-for="item in items"
                :key="item.id"
            >
                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ item.patient.name }}
                </th>
                <td class="px-6 py-4">
                    {{ item.doctor.name }}
                </td>
                <td class="px-6 py-4">
                    {{ item?.date }} {{ item?.time }}
                </td>
                <td class="px-6 py-4">
                    <enum-label
                        :value="item.service_name"
                        :options="Object.values(SERVICES_OPTIONS)"
                    />
                </td>
                <td class="px-6 py-4" @click="$emit('click:edit', item)">
                    <div class="font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer">
                        {{ $t('edit') }}
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
