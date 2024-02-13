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

console.log("ORDERS", fe_data.orders);

const defaultHeaders = [
    {
        show: true, 
        key: "id", 
        title: "labels.id", 
        sortable: true, 
        filterable: true,
        searchable: true,
        display_order: 1
    },{
        show: true, 
        key: "forwarder", 
        title: "labels.forwarder", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 1
    },{
        show: true, 
        key: "type_of_transport", 
        title: "labels.type_of_transport", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 2
    },{
        show: true, 
        key: "origin", 
        title: "labels.origin", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 3
    },{
        show: true, 
        key: "status", 
        title: "labels.status", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 4
    },{
        show: true, 
        key: "customer_reference", 
        title: "labels.customer_reference", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 5
    },{
        show: true, 
        key: "provision", 
        title: "labels.provision", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 6
    },
    // {
    //     show: true, 
    //     key: "order_edited_events", 
    //     title: "labels.order_edited_events", 
    //     sortable: true, 
    //     filterable: true, 
    //     searchable: true,
    //     display_order: 7
    // },
    {
        show: false, 
        key: "currency", 
        title: "labels.currency", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 7
    },{
        show: false, 
        key: "order_date", 
        title: "labels.order_date", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 7
    },{
        show: false, 
        key: "purchase_price", 
        title: "labels.purchase_price", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 7
    },{
        show: false, 
        key: "month_and_year", 
        title: "labels.month_and_year", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 7
    },{
        show: false, 
        key: "created_at", 
        title: "labels.created_at", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 7
    },{
        show: false, 
        key: "updated_at", 
        title: "labels.updated_at", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 7
    },{
        show: false, 
        key: "payment_method", 
        title: "labels.payment_method", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 7
    },{
        show: false, 
        key: "easy_bill_customer_id", 
        title: "labels.easy_bill_customer_id", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 7
    },{
        show: false, 
        key: "last_update", 
        title: "labels.last_update", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 7
    },{
        show: false, 
        key: "last_editor", 
        title: "labels.last_editor", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        display_order: 7
    }
]


</script>