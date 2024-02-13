<template>
    <Head title="Address" />
    <AddressesTable 
        :actions="['edit', 'show']" 
        :getData="() => {}"
        :title="$t('labels.orders')" 
        :data="fe_data.addresses" 
        :headers="defaultHeaders"
    />

    <Pagination :links="fe_data.pagination" />
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import { reactive, computed, watch, onMounted, nextTick, ref } from 'vue';
import { ElMessage, ElMessageBox, ElTable } from 'element-plus';
import { useAddressStore } from '@/Stores/addressStore';
import _ from 'lodash';
import AddressesTable from '@/Components/Tables/AddressesTable.vue';
import Pagination from '@/Components/Pagination/Pagination.vue';

import headers from '@/config/Tables/addressHeaders';

// Default headers for the table
const defaultHeaders = headers;

    // PROPS
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
    addresses: props.data.data,
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
