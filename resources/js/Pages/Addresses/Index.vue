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


// Default headers for the table
const defaultHeaders = [
    { 
        show: false, 
        key: "id", 
        title: "labels.id", 
        sortable: true, 
        filterable: true, 
        searchable: false, 
        search_key: 'id', 
        display_order: 1
    },
    { 
        show: true, 
        key: "customer_id", 
        title: "labels.customer_id", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'customer_id', 
        display_order: 1
    },
    { 
        show: true, 
        key: "forwarder_id", 
        title: "labels.forwarder_id", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'forwarder_id', 
        display_order: 2
    },
    { 
        show: true, 
        key: "country_id", 
        title: "labels.country_id", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'country_id', 
        display_order: 3
    },
    { 
        show: true, 
        key: "partner_id", 
        title: "labels.partner_id", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'partner_id', 
        display_order: 4
    },
    { 
        show: true, 
        key: "company_name", 
        title: "labels.company_name", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'company_name', 
        display_order: 5
    },
    { 
        show: true, 
        key: "first_name", 
        title: "labels.first_name", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'first_name', 
        display_order: 6
    },
    { 
        show: true, 
        key: "last_name", 
        title: "labels.last_name", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'last_name', 
        display_order: 6
    },
    { 
        show: true, 
        key: "street", 
        title: "labels.street", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'street', 
        display_order: 6
    },
    { 
        show: true, 
        key: "house_number", 
        title: "labels.house_number", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'house_number', 
        display_order: 6
    },
    { 
        show: true, 
        key: "zip_code", 
        title: "labels.zip_code", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'zip_code', 
        display_order: 6
    },
    { 
        show: true, 
        key: "city", 
        title: "labels.city", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'city', 
        display_order: 6
    },
    { 
        show: false, 
        key: "state", 
        title: "labels.state", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'state', 
        display_order: 7
    },
    { 
        show: false, 
        key: "address_additional_information", 
        title: "labels.address_additional_information", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'address_additional_information', 
        display_order: 7
    },
    { 
        show: false, 
        key: "phone", 
        title: "labels.phone", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'phone', 
        display_order: 7
    },
    { 
        show: false, 
        key: "email", 
        title: "labels.email", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'email', 
        display_order: 7
    },
    { 
        show: false, 
        key: "is_pickup", 
        title: "labels.is_pickup", 
        sortable: true, 
        filterable: true, 
        searchable: false, 
        search_key: 'is_pickup', 
        display_order: 7
    },
    { 
        show: false, 
        key: "is_delivery", 
        title: "labels.is_delivery", 
        sortable: true, 
        filterable: true, 
        searchable: false, 
        search_key: 'is_delivery', 
        display_order: 7
    },
    { 
        show: false, 
        key: "is_billing", 
        title: "labels.is_billing", 
        sortable: true, 
        filterable: true, 
        searchable: false, 
        search_key: 'is_billing', 
        display_order: 7
    },
    { 
        show: false, 
        key: "is_headquarter", 
        title: "labels.is_headquarter", 
        sortable: true, 
        filterable: true, 
        searchable: false, 
        search_key: 'is_headquarter', 
        display_order: 7
    },
    { 
        show: false, 
        key: "created_at", 
        title: "labels.created_at", 
        sortable: true, 
        filterable: true, 
        searchable: false, 
        search_key: 'created_at', 
        display_order: 7
    },
    { 
        show: false, 
        key: "updated_at", 
        title: "labels.updated_at", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'updated_at', 
        display_order: 7
    }]

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

console.log('props', props.data);

</script>
