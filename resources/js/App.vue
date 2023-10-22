<script>
import {defineComponent} from "vue";
import XSpinner from "@/components/spinner/XSpinner.vue";
import {mapState} from "vuex";

export default defineComponent({
    components: {
        XSpinner,
    },
    computed  : {
        ...mapState({
            isLoading: state => state.isLoading,
        })
    }
})
</script>

<template>
    <x-spinner v-if="isLoading"></x-spinner>
    <router-view></router-view>
    <div id="x__modals"></div>
</template>

<style scoped>

</style>
