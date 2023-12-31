<template>
    <Head title="Customers" />

    <Card>
        <Title 
            title="Customers" 
        />

        <!-- SEARCH FIELD -->
        <div class="flex flex-row justify-between">
            <SearchField
                v-model:searchTerm="data.searchTerm"
                placeholder="Search customers..."
                @getData="getData"
            />

            <el-button
                type="success"
                class="mt-1"
                @click="handleCreate"
            >Create</el-button>

        </div>

        <!-- CUSTOMERS TABLE -->
        <CustomerTable
            v-model:sortColumn="data.sortColumn"
            v-model:sortOrder="data.sortOrder"
            :customers="data.customers"
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
import { useCustomerStore } from '@/Stores/customerStore';
import SearchField from '@/Shared/SearchField.vue';
import CustomerTable from './CustomerTable.vue';
import Pagination from '@/Shared/Pagination.vue';
import Title from '@/Shared/Title.vue';


let customerStore = useCustomerStore();

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
     * Unfortunatelly, customers are coming in from backend mixed with pagination data.
     * That is what we have here in the dataFromController. We need
     * seaparted customers and separated pagination data. This will happen in computed properties.
     */
    customers: props.dataFromController.data,
    searchTerm: props.searchTermProp,
    sortColumn: props.sortColumnProp,
    sortOrder: props.sortOrderProp,

    /**
     * All pagination related data is stored here. 
     * Unfortunatelly,customers are coming in from backend mixed with pagination data.
     * That is what we have here in the dataFromController. We need
     * seaparated customers and separated pagination data. This will happen in computed properties.
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
 * It sends a request to the backend to get the customers. The backend will return the customers 
 * sorted and the pagination data. getData() does not have arguments, because it uses the
 * data from data(). Because every search/sort/paginate change is in the data().
 * Now customers from this function arrive to props. There is a watcher for props, that sends customers
 * from props to Pinia store.
 */
let getData = () => {
    const customers = router.get(
        '/customers',
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
 * This function is triggered when the user clicks on the create new customer button.
 */
const handleCreate = () => {
    router.get('customers/create');
};


/**
 * Sends the delete customer request to the backend.
 */
const handleDelete = (index, object) => {

    // Asks for confirmation message, for deleting the customer.
    ElMessageBox.confirm(
        `Customer  ${object.company_name} will be deleted. Continue?`,
        'Warning',
        {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning',
        }
    )
    .then(() => {
        //If the deleting wish is confirmed, then we send the delete request to the backend.
        router.delete(
            `/customers/${object.id}`,
            {
                onSuccess: () => {
                    ElMessage({
                        message: 'Customer deleted successfully',
                        type: 'success',
                    });
                    router.reload({ only: ['dataFromController'] });
                },
                onError: (errors) => {
                    ElMessage.error('Oops, something went wrong while deleting a customer.')
                    ElMessage(errors);
                }
            }
        )
    })
    .catch(() => {
        //If the deleting wish is canceled, then we show a message.
        ElMessage({
            type: 'info',
            message: 'Delete canceled',
        })
    })    
};

</script>
