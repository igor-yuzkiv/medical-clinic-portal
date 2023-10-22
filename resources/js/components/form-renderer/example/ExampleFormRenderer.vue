<script setup>
import XFormRenderer, {FieldType} from "@/components/form-renderer";
import {ref} from "vue";
import {Button} from "flowbite-vue";


const formSchema = {
    customer_name: {
        type       : FieldType.text,
        label      : "Customer Name",
        required   : true,
        placeholder: "Enter customer name"
    },
    type         : {
        type   : FieldType.select,
        label  : "Type",
        options: [
            {name: "Individual", value: "individual"},
            {name: "Company", value: "company"},
        ],
    },
    comment      : {
        type       : FieldType.textarea,
        label      : "Comment",
        rows       : 3
    },
    check      : {
        type       : FieldType.checkbox,
        label      : "Check"
    }
};

const formValue = ref({});
</script>

<template>
    <div class="flex flex-col gap-y-2">
        <XFormRenderer
            :schema="formSchema"
            v-model="formValue"
        >
        </XFormRenderer>
    </div>
</template>

<style scoped>

</style>
