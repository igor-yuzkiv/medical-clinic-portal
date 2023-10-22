<script setup>

import {SERVICES_OPTIONS} from "@/constants/domain.js";
import EnumLabel from "@/components/enum-label/EnumLabel.vue";
import {Button} from "flowbite-vue";
import {Icon} from "@iconify/vue";

defineEmits(['click:edit'])
defineProps({
    items: {
        type   : Array,
        default: () => []
    }
})

</script>

<template>
    <div class="relative w-full overflow-x-auto shadow-md sm:rounded-lg ">
        <table
            class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
            v-if="items?.length"
        >
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    {{ $t('service') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ $t("patient") }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ $t("doctor") }}
                </th>
                <th scope="col" class="px-6 py-3 hidden md:table-cell">
                    {{ $t("date") }}
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
                <td class="px-6 py-4 w-10">
                    <enum-label
                        :value="item.service_name"
                        :options="Object.values(SERVICES_OPTIONS)"
                    />
                </td>
                <th
                    scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                >
                    {{ item?.patient_name }}
                    <div class="text-sm text-gray-500 block md:hidden">
                        {{ item?.date }} {{ item?.time }}
                    </div>
                </th>
                <td class="px-6 py-4">
                    {{ item?.doctor_name }}
                </td>
                <td class="px-6 py-4 hidden md:table-cell">
                    {{ item?.date }} {{ item?.time }}
                </td>
                <td class="px-6 py-4 text-right">
                    <Button
                        outline square
                        @click="$emit('click:edit', item)"
                        class="!rounded-full"
                        :title="$t('edit')"
                    >
                        <Icon icon="mdi:pencil"/>
                    </Button>
                </td>
            </tr>
            </tbody>
        </table>

        <div
            class="flex flex-col flex-grow items-center justify-center h-full text-gray-500"
            v-else
        >
            <Icon icon="cil:sad" class="w-32 h-32"/>
            <div class="mt-2 text-2xl">
                {{ $t('no_records_found') }}
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
