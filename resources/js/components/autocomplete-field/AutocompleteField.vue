<script setup>
import {Input} from "flowbite-vue";
import {onMounted, ref} from "vue";
import {useOnClickOutside} from "@/composable/useOnClickOutside.js";
import {Icon} from "@iconify/vue";

const emit = defineEmits(['update:modelValue', 'click:append'])
const props = defineProps({
    modelValue   : {
        type   : String,
        default: ''
    },
    placeholder  : {
        type   : String,
        default: ''
    },
    itemKey      : {
        type   : String,
        default: 'id'
    },
    itemLabel    : {
        type   : String,
        default: 'name'
    },
    itemsProvider: {
        type   : Function,
        default: null
    },
    label        : {
        type   : String,
        default: ''
    },
    appendIcon   : {
        type   : String,
        default: null
    },
    required   : {
        type   : Boolean,
        default: false
    },
})

const isOpenList = ref(false);
const containerRef = ref(null);
const keywordQuery = ref('');
const items = ref([]);
const searchTimeoutId = ref(null);
const isLoading = ref(false);


function handleOpenList() {
    isOpenList.value = true;
}

function handleHideList() {
    isOpenList.value = false;
}

async function handleLoadItems() {
    if (typeof props.itemsProvider !== "function") {
        console.warn("itemsProvider must be a function");
        return;
    }
    isLoading.value = true;
    const response = await props.itemsProvider(keywordQuery.value)
        .catch(console.error)
        .finally(() => isLoading.value = false);

    if (!Array.isArray(response)) {
        console.warn("itemsProvider must return an array");
        return;
    }
    items.value = response;
}

function onKeywordQueryChange() {
    if (searchTimeoutId.value) {
        clearTimeout(searchTimeoutId.value);
    }
    searchTimeoutId.value = setTimeout(() => {
        handleLoadItems();
    }, 300)
}

function handleSelectItem(item) {
    keywordQuery.value = item[props.itemLabel];
    emit('update:modelValue', item[props.itemKey]);
    handleHideList();
}

onMounted(async () => {
    await handleLoadItems().then(() => {
        if (props.modelValue) {
            const item = items.value.find(item => item[props.itemKey] === props.modelValue);
            if (item) {
                keywordQuery.value = item[props.itemLabel];
            }
        }
    })
})

useOnClickOutside(containerRef, handleHideList)
</script>

<template>
    <div class="relative" ref="containerRef">
        <div class="flex items-center gap-x-1">

            <label class="font-medium text-sm">
                <span v-if="required" class="text-red-500 font-semibold">*</span>
                {{ label }}
            </label>

            <!--loading indicator-->
            <div role="status" v-if="isLoading">
                <svg aria-hidden="true" class="w-4 h-4 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor"/>
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill"/>
                </svg>
                <span class="sr-only">isLoading...</span>
            </div>
        </div>

        <div class="flex w-full items-center mt-1 relative">
            <Input
                class="w-full"
                @focus="handleOpenList"
                v-model="keywordQuery"
                @input="onKeywordQueryChange"
                :placeholder="placeholder"
            />

            <Icon
                v-if="appendIcon"
                :icon="appendIcon"
                class="absolute top-[5px] right-1 w-8 h-8 text-gray-400 cursor-pointer rounded-full hover:bg-gray-200 p-1"
                @click="$emit('click:append', keywordQuery, $event)"
            />
        </div>

        <!-- Dropdown menu -->
        <aside
            v-show="isOpenList"
            class="absolute w-full z-10 bg-white divide-y divide-gray-100 rounded-lg shadow max-h-44 overflow-y-auto"
        >
            <ul class="py-2 text-sm text-gray-700">
                <li
                    class="cursor-pointer"
                    v-for="item in items"
                    :key="item[props.itemKey]"
                    @click="handleSelectItem(item)"
                >
                    <div class="block px-4 py-2 hover:bg-gray-100">
                        {{ item[props.itemLabel] }}
                    </div>
                </li>
            </ul>
        </aside>
    </div>
</template>

<style scoped>

</style>
