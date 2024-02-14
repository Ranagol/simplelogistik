<template>
    <Head title="Address" />
    <AddressesTable 
        :actions="['edit', 'show']" 
        :getData="() => {}"
        :title="$t('labels.orders')" 
        :data="fe_data.addresses.data" 
        :headers="defaultHeaders"
    />

    <Pagination :links="buildPaginationData(fe_data.addresses)" />
</template>

<script setup>
import { reactive } 
    from 'vue';

import AddressesTable 
    from '@/Components/Tables/AddressesTable.vue';

import Pagination 
    from '@/Components/Pagination/Pagination.vue';

import headers 
    from '@/config/Tables/addressHeaders';

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
    addresses: props.records,
});


</script>
