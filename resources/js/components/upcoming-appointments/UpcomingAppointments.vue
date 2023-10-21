<script setup>
import {Timeline, TimelineContent, TimelineItem, TimelinePoint, TimelineTime, TimelineTitle} from "flowbite-vue";
import {onMounted, ref} from "vue";
import {appointmentApi} from "@/api/appointmentApi.js";
import PatientLookup from "@/components/patient-lookup/PatientLookup.vue";
import EnumLabel from "@/components/enum-label/EnumLabel.vue";
import {SERVICES_OPTIONS} from "@/constants/domain.js";

const items = ref();

</script>

<template>
    <Timeline>

        <timeline-item
            class="mb-2"
            v-for="item in items"
        >
            <timeline-point>
            </timeline-point>
            <timeline-content>
                <timeline-time>
                    {{ item.time }}
                </timeline-time>
                <timeline-title class="flex gap-x-1">
                    <enum-label :options="Object.values(SERVICES_OPTIONS)" :value="item?.service_name"/>
                    <patient-lookup :value="item?.patient" clickable/>
                </timeline-title>
            </timeline-content>
        </timeline-item>

    </Timeline>
</template>

<style scoped>

</style>
