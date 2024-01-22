<template>
    <TableWithContent 
        :actions="['edit', 'show']" 
        @getData="getData" 
        :title="$t('labels.orders')" 
        :data="props.dataFromController.data" 
        :headers="object.headers"
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
        {key: "order_reference", title: "#", sortable: true, filterable: true, display_order: 1},
        {key: "type_of_transport", title: "Transportweg", sortable: true, filterable: true, display_order: 2},
        {key: "customer_reference", title: "Kundennummer", sortable: true, filterable: true, display_order: 3}
    ]


    const object = reactive({
        headers: headers
    })

</script>