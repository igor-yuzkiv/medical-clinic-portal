<script>
import {defineComponent} from "vue";
import {Icon} from "@iconify/vue";

export default defineComponent({
    components: {Icon},
    emits     : ["click:next", "click:prev", "change:page"],
    props     : {
        per_page    : {
            type   : Number,
            default: 1,
        },
        current_page: {
            type   : Number,
            default: 1,
        },
        total       : {
            type   : Number,
            default: 0,
        },
        total_pages : {
            type   : Number,
            default: 0,
        }
    },
    computed  : {
        getShowedRecords() {
            const showedRecords = this.current_page * this.per_page
            return (showedRecords <= this.total) ? showedRecords : this.total;
        },
        hasPrevPage() {
            return (this.current_page > 1)
        },
        hasNextPage() {
            return (this.current_page < this.total_pages)
        }
    },
    methods   : {
        onClickNextPage() {
            if (!this.hasNextPage) {
                return;
            }
            this.$emit("change:page", this.current_page + 1);
            this.$emit("click:next", this.current_page + 1);
        },
        onClickPrevPage() {
            if (!this.hasPrevPage) {
                return;
            }
            this.$emit("change:page", this.current_page - 1);
            this.$emit("click:prev", this.current_page - 1);
        }
    }
})
</script>

<template>
    <div class="flex items-center justify-end gap-x-3">
        <button
            class="inline-flex items-center"
            :class="!hasPrevPage ? 'text-gray-500' : ''"
            title="Previous"
            @click="onClickPrevPage"
            :disabled="!hasPrevPage"
        >
            <Icon class="text-lg" icon="mdi-chevron-left"></Icon>
        </button>

        <div class="font-medium">
            {{ current_page }} із {{ total_pages }}
        </div>

        <button
            class="inline-flex items-center"
            :class="!hasNextPage ? 'text-gray-500' : ''"
            title="Next"
            @click="onClickNextPage"
            :disabled="!hasNextPage"
        >
            <Icon class="text-lg" icon="mdi-chevron-right"></Icon>
        </button>
    </div>
</template>

<style scoped>

</style>
