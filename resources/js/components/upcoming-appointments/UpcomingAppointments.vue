<script setup>
import {
    Timeline,
    TimelineContent,
    TimelineItem,
    TimelinePoint,
    TimelineTime,
    TimelineTitle
} from "flowbite-vue";
import {onMounted, ref} from "vue";
import {appointmentApi} from "@/api/appointmentApi.js";
import EnumLabel from "@/components/enum-label/EnumLabel.vue";
import {SERVICES_OPTIONS} from "@/constants/domain.js";
import moment from "moment";

const items = ref();

async function loadItems() {
    const response = await appointmentApi
        .fetchUpcoming()
        .then(({data}) => data)
        .catch(error => {
            console.error(error);
        });

    if (response?.data && Array.isArray(response.data)) {
        items.value = response.data.map(item => {
            return {
                ...item,
                _isPassed: moment(item.date_time).isBefore(moment()),
            }
        });
    }
}

onMounted(loadItems)
</script>

<template>
    <Timeline>
        <timeline-item
            class="mb-2"
            v-for="item in items"
            :key="item.id"
        >
            <timeline-point>
            </timeline-point>
            <timeline-content>
                <timeline-time>
                    <div class="flex gap-x-1">
                        <div :class="{'line-through':item._isPassed}">
                            {{ item.time }}
                        </div>
                        <enum-label
                            :options="Object.values(SERVICES_OPTIONS)"
                            :value="item?.service_name"
                        />
                    </div>
                </timeline-time>
                <timeline-title class="flex gap-x-1">
                    <div class="flex flex-col">
                        <div class="cursor-pointer text-blue-600 hover:underline">
                            {{ item?.patient_name }}
                        </div>
                        <div v-if="item?.patient_phone" class="text-sm text-gray-500">
                            {{ item.patient_phone }}
                        </div>
                    </div>
                </timeline-title>
            </timeline-content>
        </timeline-item>
    </Timeline>
</template>
<style scoped>
</style>
