<template>
    <Head
        :title="$t('labels.customers')"
    />

    <CustomerTableWithActions
        :actions="['show', 'edit']"
        :title="$t('labels.customers')"
        :data="fe_data.customers.data"
        :headers="defaultHeaders"
        :props="props"
    ></CustomerTableWithActions>
    <Pagination :links="buildPaginationData(fe_data.customers)" />
</template>

<script setup>
import { reactive } from 'vue';

import CustomerTableWithActions from '@/Components/Tables/CustomerTableWithActions.vue';
import Pagination from "@/Components/Pagination/Pagination.vue";

import headers from "@/config/Tables/customerHeaders";
const defaultHeaders = headers;

let props = defineProps( 
    {
        errors: Object, 
        records: Object,
        search: String,
        search_in: Array,
        order_by: String,
        order: String,
    }
);

// Setting Frontend Data
const fe_data = reactive({
    customers: props.records,
});

</script>
