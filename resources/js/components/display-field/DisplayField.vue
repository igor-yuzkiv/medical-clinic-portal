<script setup>

import {useRouter} from "vue-router";

const props = defineProps({
    label  : {
        type    : String,
        required: true
    },
    value  : {
        default: null
    },
    variant: {
        type     : String,
        default  : "default",
        validator: (value) => ["default", "tiny", "link"].includes(value),
    },
    route  : {
        type   : Object,
        default: null
    }
})

const variants = {
    default: {
        label: "text-black font-medium",
        value: "text-alabaster-800"
    },
    tiny   : {
        label: "text-gray-700 text-sm",
        value: "text-alabaster-800 text-sm"
    },
    link   : {
        label: "text-gray-600 text-sm",
        value: "text-blue-700 text-sm hover:underline cursor-pointer"
    }
}
const router = useRouter()

function onClick() {
    if (props.variant === "link" && props.route) {
        router.push(props.route).catch(console.error)
    }
}

</script>

<template>
    <div class="flex text-lg items-center gap-x-1">
        <span :class="variants[variant].label">
            {{ label }}:
        </span>
        <span
            @click.stop="onClick"
            :class="variants[variant].value"
        >
            <slot name="value">
                {{ value ?? "-" }}
            </slot>
        </span>
    </div>
</template>

<style scoped>

</style>
