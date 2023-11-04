<script setup>
/*
* https://vue3datepicker.com/props/general-configuration/
* */
import {computed} from "vue";
import {uk} from 'date-fns/locale';
import moment from "moment";
import {DATE_TIME_FORMAT} from "@/constants/domain.js";

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type   : [String, Number],
        default: null
    },
    settings  : {
        type   : Object,
        default: () => ({})
    },
    enableTimePicker: {
        type   : Boolean,
        default: false
    }
})


const label = computed(() => props.settings?.label ?? '')
const readonly = computed(() => Boolean(props.settings?.readonly))

const realModel = computed({
    get() {
        return props.modelValue
    },
    set(value) {
        value = value ? moment(value).format(DATE_TIME_FORMAT) : null
        emit('update:modelValue', value)
    }
})

</script>

<template>
    <div class="flex flex-col w-full">
        <label class="font-medium text-sm text-gray-800">{{ label }}</label>
        <VueDatePicker
            class="x__date-time-picker w-full mt-2"
            v-model="realModel"
            :label="label"
            :readonly="readonly"
            :cancelText="$t('cancel')"
            :selectText="$t('select')"
            :format-locale="uk"
            :enable-time-picker="enableTimePicker"
        />
    </div>
</template>

<style scoped>
.x__date-time-picker >>> .dp__input_wrap input {
    @apply rounded-lg py-2 bg-gray-50 border-gray-300 text-gray-700
}

.x__date-time-picker >>> .dp__action_select {
    @apply bg-blue-500 text-white
}
</style>
