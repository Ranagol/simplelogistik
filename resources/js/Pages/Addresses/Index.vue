<template>
    <Head title="Address" />
    <AddressesTable 
        :actions="['edit', 'show']" 
        :getData="getData" 
        :title="$t('labels.orders')" 
        :data="data.addresses" 
        :headers="defaultHeaders"
        :filters="data"
    />

    <Pagination :links="data.paginationData" />
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
        dataFromController: Object,

        /**
         * We need to pass the searchTermProp, sortColumnProp and sortOrderProp from the backend
         * to the frontend. So the backend sends them, and this component receives them as props.
         * However, props data can't be changed. So we need to store them in data().
         */
        searchTermProp: String,
        sortColumnProp: String,
        sortOrderProp: String,
    }
);

let data = reactive({
    /**
     * Unfortunatelly, addresses are coming in from backend mixed with pagination data.
     * That is what we have here in the dataFromController. We need
     * seaparted addresses and separated pagination data. This will happen in computed properties.
     */
    addresses: props.dataFromController.data,
    searchTerm: props.searchTermProp,
    sortColumn: props.sortColumnProp,
    sortOrder: props.sortOrderProp,

    /**
     * All pagination related data is stored here. 
     * Unfortunatelly,addresses are coming in from backend mixed with pagination data.
     * That is what we have here in the dataFromController. We need
     * seaparated addresses and separated pagination data. This will happen in computed properties.
     * Here. So, this is the pagination related data. And a small reminder:
     * 
     * el-pagination        Laravel ->paginate()
     * current-page	        paginationData.current_page         Where the user is currently
     * page-size	        paginationData.per_page             Number of items / page
     * total	            paginationData.total                Number of all db records
     */
    paginationData: _.omit({...props.dataFromController}, 'data')
});

/**
 * This is the data that will be passed to the AddressesTable component.
 * It is a computed property, because it depends on the data from the backend.
 */
let getData = () => {}

/**
 * This function is triggered when the user clicks on the create new address button.
 */
const handleCreate = () => {
    router.get('addresses/create');
};

</script>
