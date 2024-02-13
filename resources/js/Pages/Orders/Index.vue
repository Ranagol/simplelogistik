<template>
    <Head
        :title="$t('labels.orders')"
    />
    <OrderTableWithContent 
        :actions="['edit', 'show']" 
        :title="$t('labels.orders')" 
        :data="fe_data.orders" 
        :headers="defaultHeaders"
    ></OrderTableWithContent>
    <Pagination :links="fe_data.pagination" />
</template>
<script setup>
import Pagination from '@/Components/Pagination/Pagination.vue';
import OrderTableWithContent from '@/Components/Tables/OrderTableWithContent.vue';
import { reactive } from 'vue';

import headers from "@/config/Tables/orderHeaders";
const defaultHeaders = headers;

let props = defineProps( 
    {
        errors: Object, 
        data: Object,
        search: String,
        search_in: Array,
        order_by: String,
        order: String,
    }
);

// Setting Frontend Data
const fe_data = reactive({
    orders: props.data.data,
    pagination: {
        current_page: props.data.current_page,
        last_page: props.data.last_page,
        from: props.data.from,
        to: props.data.to,
        links: props.data.links,
        total: props.data.total,
        per_page: props.data.per_page,
        path: props.data.path,
        first_page_url: props.data.first_page_url,
        last_page_url: props.data.last_page_url,
    } ,
});


</script>