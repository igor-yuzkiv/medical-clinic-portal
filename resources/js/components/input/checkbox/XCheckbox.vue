<script>
import {defineComponent} from "vue"

export default defineComponent({
    emits: ["update:modelValue"],
    props: {
        modelValue: {
            type   : Boolean,
            default: false,
        },
        label     : {
            type   : String,
            default: "",
        },
    }
});
</script>

<template>
    <label
        class="flex items-center"
        @click.stop="$emit('update:modelValue', $event.target.checked)"
    >
        <input
            :checked="modelValue"
            type="checkbox"
            class="form-checkbox w-4 h-4 rounded-sm focus:outline-none focus:shadow-outline-purple"
        />
        <slot name="label">
            <span class="ml-2">{{ label }}</span>
        </slot>
    </label>
</template>
