<template>
    <Head title="CargoOrder" />

    <Card>

        <Title 
            title="Cargo orders" 
        />

        <!-- SEARCH FIELD -->
        <div class="flex flex-row">
            <SearchField
                v-model:searchTerm="data.searchTerm"
                placeholder="Search cargo orders..."
                @getData="getData"
            />

            <el-button
                type="success"
                class="mt-1"
                @click="handleCreate"
            >Create</el-button>

        </div>

        <!-- CARGO ORDERS TABLE -->
        <CargoOrderTable
            v-model:sortColumn="data.sortColumn"
            v-model:sortOrder="data.sortOrder"
            :cargoOrders="data.cargoOrders"
            @getData="getData"
        />

        <!-- PAGINATION -->
        <Pagination
            v-model:paginationData="data.paginationData"
            @getData="getData"
        />
    </Card>

</template>

<script setup>
import Card from '@/Shared/Card.vue';
import _ from 'lodash';
import { router } from '@inertiajs/vue3'
import { reactive, computed, watch, onMounted, nextTick, ref } from 'vue';
import { ElMessage, ElMessageBox, ElTable } from 'element-plus';
import { useAddressStore } from '@/Stores/addressStore';
import SearchField from '@/Shared/SearchField.vue';
import Pagination from '@/Shared/Pagination.vue';
import CargoOrderTable from './CargoOrderTable.vue';
import Title from '@/Shared/Title.vue';

let addressStore = useAddressStore();

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
     * Unfortunatelly, cargoOrders are coming in from backend mixed with pagination data.
     * That is what we have here in the dataFromController. We need
     * seaparted cargoOrders and separated pagination data. This will happen in computed properties.
     */
    cargoOrders: props.dataFromController.data,
    searchTerm: props.searchTermProp,
    sortColumn: props.sortColumnProp,
    sortOrder: props.sortOrderProp,

    /**
     * All pagination related data is stored here. 
     * Unfortunatelly,cargoOrders are coming in from backend mixed with pagination data.
     * That is what we have here in the dataFromController. We need
     * seaparated cargoOrders and separated pagination data. This will happen in computed properties.
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
 * getData() is triggered by: 
 * 
 * the search button, 
 * the sorting clicks, 
 * the pagination clicks.
 * Also on input field clear/reset.
 * If enter is hit by the user.
 * 
 * It sends a request to the backend to get the cargoOrders. The backend will return the cargoOrders 
 * sorted and the pagination data. getData() does not have arguments, because it uses the
 * data from data(). Because every search/sort/paginate change is in the data().
 * Now cargoOrders from this function arrive to props. There is a watcher for props, that sends cargoOrders
 * from props to Pinia store.
 */
let getData = () => {
    router.get(
        '/cargo-orders',
        {
            /**
             * This is the data that we send to the backend.
             */
            searchTerm: data.searchTerm,
            sortColumn: data.sortColumn,
            sortOrder: data.sortOrder,
            page: data.paginationData.current_page,
            newItemsPerPage: data.paginationData.per_page,
        }
    );
};

/**
 * This function is triggered when the user clicks on the create new address button.
 */
const handleCreate = () => {
    router.get('cargo-orders/create');
};



</script>
