<script setup>
import {Icon} from "@iconify/vue";
import {computed, nextTick, useAttrs} from "vue";
import {
    borderColorVariants,
    placeHolderColorVariants,
    bgColorVariants,
    textColorVariants,
    textSizeVariants,
    componentProps,

} from "@/components/input/composables.js"

const attrs = useAttrs();

const emit = defineEmits([
    "update:modelValue",
    "change",
    "click:append",
    "click:prepend",
]);

const props = defineProps({
    modelValue : {
        default: '',
    },
    label      : {
        type   : String,
        default: '',
    },
    placeholder: {
        type   : String,
        default: '',
    },
    type       : {
        type   : String,
        default: 'text',
    },
    prependIcon: {
        type   : String,
        default: '',
    },
    appendIcon : {
        type   : String,
        default: '',
    },
    rounded    : {
        type   : Boolean,
        default: false,
    },
    filled     : {
        type   : Boolean,
        default: false,
    },
    readonly   : {
        type   : Boolean,
        default: false,
    },
    required   : {
        type   : Boolean,
        default: false,
    },
    color     : componentProps.color,
    size      : componentProps.size,
})

const getColor = computed(() => {
    return props.color || 'default';
})

const getInputAttributes = computed(() => {
    const attributes = {};

    if (props.type === 'textarea') {
        attributes['rows'] = attrs?.rows ? attrs.rows : 2;
    } else {
        attributes['type'] = props.type;
    }

    if (attrs.name) {
        attributes['name'] = attrs.name;
    }

    return attributes;
})

const getLabelAttributes = computed(() => {
    const attributes = {};

    if (attrs?.name) {
        attributes['for'] = attrs.name;
    }

    return attributes;
})

function handleChangeValue(e) {
    const value = e.target.value;
    emit('update:modelValue', value)
    nextTick(() => {
        emit('change', value)
    })
}

</script>

<template>
    <div>
        <label
            v-if="label"
            class="block mb-1 text-sm font-medium"
            :class="{[textColorVariants[getColor]]: !readonly}"
            v-bind.attr="getLabelAttributes"
        >
            {{ label }} <span class="font-semibold text-red-500" v-if="required">*</span>
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
            <Icon
                v-if="prependIcon"
                :icon="prependIcon"
                @click="$emit('click:prepend', $event)"
                class="cursor-pointer"
                :class="{
                    'h-3 w-3' : size === 'sm',
                    'h-7 w-7': size === 'lg',
                    'h-14 w-14': size === 'xl',
                    'h-5 w-5': size === 'md' || !size,
                }"
            />
            <component
                :is="type==='textarea' ? 'textarea' : 'input'"
                :readonly="readonly"
                :placeholder="placeholder"
                class="x-field-input px-1"
                :class="{
                    [placeHolderColorVariants[getColor]]: !readonly,
                    'placeholder-gray-400': readonly,
                    'rounded-full': rounded,
                    'rounded-md': !rounded,
                    'h-4' : size === 'sm',
                    'h-10': size === 'lg',
                    'h-14': size === 'xl',
                    'h-6': size === 'md' || !size,
                    'h-auto': type === 'textarea',
                }"
                :value="modelValue"
                @input="handleChangeValue"
                v-bind="getInputAttributes"
            />

            <Icon
                v-if="appendIcon"
                :icon="appendIcon"
                @click="$emit('click:append', $event)"
                class="cursor-pointer"
                :class="{
                    'h-3 w-3' : size === 'sm',
                    'h-7 w-7': size === 'lg',
                    'h-14 w-14': size === 'xl',
                    'h-5 w-5': size === 'md' || !size,
                }"
            />
        </div>
    </div>
</template>

<style scoped>
.x-field-input {
    @apply outline-0 w-full;
    background-color: inherit;
}

</style>
