<template>
    <TableWithContent 
        :actions="['edit', 'show']" 
        @getData="getData" 
        :title="$t('labels.orders')" 
        :data="props.dataFromController.data" 
        :headers="headers"
        :paginationData="props.dataFromController"
        @changeTableLayout="changeTableLayout"
    ></TableWithContent>
    <pre>{{ dataFromController.data.data }}</pre>
</template>
<script setup>
    import TableWithContent from '@/Components/Tables/OrderTableWithContent.vue';
    import Pagination from '@/Components/Pagination/Pagination.vue';
    import { reactive } from 'vue';

    let props = defineProps({
        dataFromController: Object,
    })

    const changeTableLayout = (entries) => {
        
    }

    const getData = () => {}

    const headers = [
        {key: "id", title: "labels.order-id", sortable: true, filterable: true, display_order: 1},
        {key: "forwarder", title: "labels.forwarder", sortable: true, filterable: true, display_order: 2},
        {key: "type_of_transport", title: "labels.way-of-transport", sortable: true, filterable: true, display_order: 3},
        {key: "order_date", title: "labels.order-date", sortable: true, filterable: true, display_order: 4},
        {key: "customer_reference", title: "labels.customer-reference", sortable: true, filterable: true, display_order: 5},
        {key: "last_editor", title: "labels.edit-by", sortable: true, filterable: true, display_order: 6},
        {key: "last_update", title: "labels.update-at", sortable: true, filterable: true, display_order: 7},
    ]


</script>