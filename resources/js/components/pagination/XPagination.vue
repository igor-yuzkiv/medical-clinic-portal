<script setup>

import {computed} from "vue";

const emit = defineEmits(['pageChanged']);
const props = defineProps({
    currentPage: {
        type   : Number,
        default: 1,
    },
    totalPages : {
        type   : Number,
        default: 1,
    },
    maxOnSide  : {
        type   : Number,
        default: 4,
    },
})

const pages = computed(() => {
    let start = Math.max(1, props.currentPage - props.maxOnSide);
    let end = Math.min(props.totalPages, props.currentPage + props.maxOnSide);

    start = Math.max(1, end - props.maxOnSide * 2);
    end = Math.min(props.totalPages, start + props.maxOnSide * 2);
    return Array.from({length: end - start + 1}, (_, i) => i + start)
})

const hasNext = computed(() => props.currentPage < props.totalPages);
const hasPrevious = computed(() => props.currentPage > 1);

function changePage(page) {
    if (page === props.currentPage) {
        return;
    }
    emit('pageChanged', page);
}

function nextPage() {
    if (hasNext.value) {
        changePage(props.currentPage + 1);
    }
}

function previousPage() {
    if (hasPrevious.value) {
        changePage(props.currentPage - 1);
    }
}

</script>

<template>
    <nav aria-label="Page navigation example">
        <ul class="inline-flex -space-x-px text-sm">
            <li>
                <div
                    class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg"
                    :class="{
                        'hover:bg-gray-100 hover:text-gray-700 cursor-pointer': hasPrevious,
                    }"
                    @click="previousPage"
                >
                    Previous
                </div>
            </li>

            <li
                v-for="item in pages" :key="item"
                @click="changePage(item)"
            >
                <div
                    class="flex items-center justify-center px-3 h-8 leading-tight bg-white border border-gray-300"
                    :class="{
                        'text-blue-500': item === currentPage,
                        'text-gray-500 cursor-pointer hover:bg-gray-100 hover:text-gray-700': item !== currentPage,
                    }"
                >
                    {{ item }}
                </div>
            </li>

            <li>
                <div
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg"
                    :class="{
                        'hover:bg-gray-100 hover:text-gray-700 cursor-pointer': hasNext,
                    }"
                    @click="nextPage"
                >
                    Next
                </div>
            </li>
        </ul>
    </nav>
</template>

<style scoped>

</style>
