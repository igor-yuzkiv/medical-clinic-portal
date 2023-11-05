<script setup>
import {ref} from "vue";
import {useOnClickOutside} from "@/composable/useOnClickOutside.js";
import {Icon} from "@iconify/vue";

const emit = defineEmits(["update:modelValue", "close"]);
const props = defineProps({
    modelValue: {
        type   : Boolean,
        default: false,
    },
    cardClass : {
        type   : [String, Object],
        default: "",
    },
    overlay   : {
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
    <transition name="fade" v-if="overlay">
        <div
            class="fixed top-0 left-0 w-full h-full z-10 bg-gray-900 bg-opacity-40 overflow-hidden"
            v-if="modelValue"
        />
    </transition>
    <transition name="slide-fade">
        <div class="fixed top-0 left-0 w-full h-full z-20" v-if="modelValue">
            <div class="flex flex-col items-end justify-center h-full w-full overflow-hidden">
                <div
                    ref="container"
                    :class="cardClass"
                    class="relative flex flex-col bg-white shadow-xl rounded-l-xl"
                >
                    <button
                        type="button" @click.stop="handleCloseModals"
                        class="absolute top-2 -left-3 inline-flex shrink-0 bg-gray-200 shadow-lg rounded-full p-1 hover:bg-blue-500 hover:text-white"
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
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-fade-enter-active {
    transition: all 0.2s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(100px);
    opacity: 0;
}
</style>
