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
</template>
<script setup>
    import TableWithContent from '@/Components/Tables/TableWithContent.vue';
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
        {key: "type_of_transport", title: "Transportweg", sortable: true, filterable: true, display_order: 2},
        {key: "order_date", title: "labels.order-date", sortable: true, filterable: true, display_order: 2},
        {key: "customer_reference", title: "labels.customer_reference", sortable: true, filterable: true, display_order: 2},
        {key: "last_editor", title: "labels.edit_by", sortable: true, filterable: true, display_order: 2},
        {key: "last_update", title: "labels.update_at", sortable: true, filterable: true, display_order: 2},
    ]


</script>