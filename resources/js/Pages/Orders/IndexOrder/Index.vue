<template>
    <TableWithContent 
        :actions="['edit', 'show']" 
        @getData="getData" 
        :title="$t('labels.orders')" 
        :data="props.dataFromController.data" 
        :headers="headers"
        :paginationData="props.dataFromController.record"
        @changeTableLayout="changeTableLayout"
    ></TableWithContent>
    <pre>{{ props.dataFromController.data.data[0] }}</pre>
</template>
<script setup>
    import TableWithContent from '@/Components/Tables/OrderTableWithContent.vue';

    let props = defineProps({
        dataFromController: Object,
    })

    const changeTableLayout = (entries) => {
        
    }

    const getData = () => {}


    const headers = [
        {
            show: true, 
            key: "id", 
            title: "labels.id", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 1
        },{
            show: true, 
            key: "forwarder", 
            title: "labels.forwarder", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 1
        },{
            show: true, 
            key: "type_of_transport", 
            title: "labels.type_of_transport", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 2
        },{
            show: true, 
            key: "origin", 
            title: "labels.origin", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 3
        },{
            show: true, 
            key: "status", 
            title: "labels.status", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 4
        },{
            show: true, 
            key: "customer_reference", 
            title: "labels.customer_reference", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 5
        },{
            show: true, 
            key: "provision", 
            title: "labels.provision", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 6
        },{
            show: true, 
            key: "order_edited_events", 
            title: "labels.order_edited_events", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 7
        },{
            show: false, 
            key: "currency", 
            title: "labels.currency", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 7
        },{
            show: false, 
            key: "order_date", 
            title: "labels.order_date", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 7
        },{
            show: false, 
            key: "purchase_price", 
            title: "labels.purchase_price", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 7
        },{
            show: false, 
            key: "month_and_year", 
            title: "labels.month_and_year", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 7
        },{
            show: false, 
            key: "created_at", 
            title: "labels.created_at", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 7
        },{
            show: false, 
            key: "updated_at", 
            title: "labels.updated_at", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 7
        },{
            show: false, 
            key: "payment_method", 
            title: "labels.payment_method", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 7
        },{
            show: false, 
            key: "easy_bill_customer_id", 
            title: "labels.easy_bill_customer_id", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 7
        },{
            show: false, 
            key: "last_update", 
            title: "labels.last_update", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 7
        },{
            show: false, 
            key: "last_editor", 
            title: "labels.last_editor", 
            NULLplaceholder: "-",
            sortable: true, 
            filterable: true, 
            display_order: 7
        },]


</script>