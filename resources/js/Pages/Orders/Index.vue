<template>
    <Head
        :title="$t('labels.orders')"
    />
    <OrderTableWithContent 
        :search="search"
        :search_in="search_in"
        :actions="['edit', 'show']" 
        :title="$t('labels.orders')" 
        :data="fe_data.orders" 
        :headers="defaultHeaders"
    ></OrderTableWithContent>
    <Pagination :links="buildPaginationData(fe_data.orders)" />
</template>
<script setup>
import Pagination 
    from '@/Components/Pagination/Pagination.vue';

import OrderTableWithContent 
    from '@/Components/Tables/OrderTableWithContent.vue';

import { reactive } 
    from 'vue';


import headers 
    from "@/config/Tables/orderHeaders";

const defaultHeaders = headers;

let props = defineProps( 
    {
        records: Object,
        search: String,
        search_in: Array,
        order_by: String,
        order: String,
    }
);


// Setting Frontend Data
const fe_data = reactive({
    orders: props.records,
});


</script>