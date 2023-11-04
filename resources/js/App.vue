<script>
import {defineComponent} from "vue";
import LoadingIndicator from "@/components/loading-indicator/LoadingIndicator.vue";
import {useRootStore} from "@/store/useRootStore.js";

export default defineComponent({
    components: {
        LoadingIndicator,
    },
    setup() {
        const rootStore = useRootStore();
        return {rootStore};
    },
    computed: {
        isLoading() {
            return this.rootStore.showLoader;
        },
    }
})
</script>

<template>
    <loading-indicator v-if="isLoading"></loading-indicator>
    <router-view></router-view>
    <div id="x__modals"></div>
</template>

<style scoped>

</style>
