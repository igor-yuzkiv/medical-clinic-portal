<script>
import {defineComponent} from "vue";
import LoadingIndicator from "@/components/loading-indicator/LoadingIndicator.vue";
import {mapState} from "vuex";

export default defineComponent({
    components: {
        LoadingIndicator,
    },
    computed  : {
        ...mapState({
            isLoading: state => state.isLoading,
        })
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
