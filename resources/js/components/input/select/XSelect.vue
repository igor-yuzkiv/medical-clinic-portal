<script setup>
import {
    borderColorVariants,
    bgColorVariants,
    textColorVariants,
    textSizeVariants,
    componentProps
} from "@/components/input/composables.js"
import {computed, nextTick} from "vue";

const emit = defineEmits(["update:modelValue", "change"])
const props = defineProps({
    modelValue: {
        default: null,
    },
    options   : {
        type   : Array,
        default: () => ([])
    },
    label     : {
        type   : String,
        default: "",
    },
    itemValue : {
        type   : String,
        default: null,
    },
    itemTitle : {
        type   : String,
        default: null,
    },
    rounded   : {
        type   : Boolean,
        default: false,
    },
    filled    : {
        type   : Boolean,
        default: false,
    },
    readonly  : {
        type   : Boolean,
        default: false,
    },
    required  : {
        type   : Boolean,
        default: false,
    },
    color     : componentProps.color,
    size      : componentProps.size,
})

const getColor = computed(() => {
    return props.color || 'default';
})

const getItemTitle = (item) => {
    return item[props.itemTitle] || item;
}

const getItemValue = (item) => {
    return item[props.itemValue] || item;
}

function handleChangeValue(e) {
    emit("update:modelValue", e.target.value);
    nextTick(() => {
        emit("change", e.target.value);
    })
}
</script>

<template>
    <div>
        <label
            v-if="label"
            class="block mb-1 text-sm font-medium"
        >
            {{ label }}
            <span class="font-semibold text-red-500" v-if="required">*</span>
        </label>
        <div
            class="x-filed-container flex items-center gap-x-1 p-1 border"
            :class="{
                [borderColorVariants[getColor]]: !readonly,
                [textColorVariants[getColor]]: !readonly,
                [bgColorVariants[getColor]]: filled,
                [textSizeVariants[size || 'md']]: true,
                'bg-gray-200': readonly,
                'text-gray-400': readonly,
                'rounded-full': rounded,
                'rounded-md': !rounded,
            }"
        >
            <select
                :value="modelValue"
                @input="handleChangeValue($event)"
                class="x-field-input px-1"
                :class="{
                    'rounded-full': rounded,
                    'rounded-md': !rounded,
                    'h-4' : size === 'sm',
                    'h-10': size === 'lg',
                    'h-14': size === 'xl',
                    'h-6': size === 'md' || !size,
                }"
            >
                <option
                    v-for="item in options"
                    :key="item[itemValue]"
                    v-text="getItemTitle(item)"
                    :value="getItemValue(item)"
                />
            </select>
        </div>
    </div>
</template>

<style scoped>
.x-field-input {
    @apply outline-0 w-full;
    background-color: inherit;
}
</style>
