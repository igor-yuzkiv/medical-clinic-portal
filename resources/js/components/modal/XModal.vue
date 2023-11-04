<script setup>
import {ref} from "vue";
import {useOnClickOutside} from "@/hooks/useOnClickOutside.js";
import {Icon} from "@iconify/vue";

const emit = defineEmits(["update:modelValue", "close"]);
const props = defineProps({
    modelValue: {
        type   : Boolean,
        default: false,
    },
})
const container = ref(null);


function handleCloseModals() {
    if (props.modelValue) {
        emit("update:modelValue", false);
        emit("close");
    }
}


useOnClickOutside(container, handleCloseModals)
</script>

<template>
    <transition
        enter-active-class="duration-300 ease-out"
        enter-from-class="transform opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="transform opacity-0"
    >
        <div
            class="fixed top-0 left-0 right-0 bottom-0 z-20 bg-gray-900 bg-opacity-40 overflow-hidden"
            ref="container"
            v-if="modelValue"
        >
            <div class="flex justify-end h-full w-full overflow-hidden">
                <div class="relative flex flex-col h-full w-[95%] sm:w-2/4 bg-white shadow-sm rounded-l-xl">
                    <button
                        type="button"
                        @click.stop="handleCloseModals"
                        class="absolute top-2 -left-3 inline-flex shrink-0 bg-gray-200 shadow-md rounded-full p-1 hover:bg-blue-500 hover:text-white"
                    >
                        <Icon icon="pajamas:close"/>
                    </button>

                    <slot></slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<style scoped>

</style>
