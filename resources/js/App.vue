<script setup>
import XSpinner from "@/components/spinner/XSpinner.vue";
import {useStore} from "vuex";
import {computed} from "vue";
const store = useStore();
const isLoading = computed(() => store.state.isLoading);
</script>

<template>
    <x-spinner v-if="isLoading"></x-spinner>
    <router-view></router-view>
    <div id="x__modals"></div>
</template>

<style scoped>

</style>
