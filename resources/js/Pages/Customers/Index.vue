<template>
    <Head
        :title="$t('labels.customers')"
    />
    <CustomerTableWithActions
        :actions="['show', 'edit']"
        :title="$t('labels.customers')"
        :data="fe_data.customers"
        :headers="headers"
    />
    <Pagination :links="fe_data.pagination" />
</template>

<script setup>
import _ from "lodash"
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue';
import { ElMessage, ElMessageBox } from 'element-plus';
import { useCustomerStore } from '@/Stores/customerStore';

import CustomerTableWithActions from '@/Components/Tables/CustomerTableWithActions.vue';
import Pagination from "@/Components/Pagination/Pagination.vue";

const headers = [
    {
        key: "id",
        text: 'labels.customer-id',
        searchable: true,
    },
    {
        key: "first_name",
        text: 'labels.first-name',
        searchable: true,
        orderable: true
    },
    {
        key: "last_name",
        text: 'labels.last-name',
        searchable: true,
        orderable: true
    },
    {
        key: "company_name",
        text: 'labels.company-name',
        searchable: true,
    },
    {
        key: "private_customer",
        text: 'labels.business-customer',
        searchable: true,
        orderable: true
    }
]

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
    customers: props.data.data,
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
