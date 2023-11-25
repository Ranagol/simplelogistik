<template>
    <Head title="Customers" />

    <Card>
        <h1>Customers</h1>

        <SearchField
            @getCustomers="getCustomers"
        />

        <!-- CREATE NEW CUSTOMER POPUP -->
        <Popup
            @submitCustomer="submitCustomer"
        ></Popup>

        <!-- CREATE NEW CUSTOMER BUTTON -->
        <el-button
            @click="handleCreate"
            type="info"
        >Create new customer</el-button>

        <!-- CUSTOMERS TABLE -->
        <Table
            @getCustomers="getCustomers"
            @handleEdit="handleEdit"
            @handleDelete="handleDelete"
        />

        

        <!-- PAGINATION -->
        <Pagination
            @getCustomers="getCustomers"
        />
    </Card>

</template>

<script lang="ts" setup>
import { Customer } from '@/types/models/Customer';
import Card from '@/Shared/Card.vue';
import _ from 'lodash';
import Popup from '@/Shared/Popup.vue';
import { router } from '@inertiajs/vue3'
import { reactive, computed, watch, onMounted, nextTick, ref } from 'vue';
import { ElMessage, ElMessageBox, ElTable } from 'element-plus';
import { useCustomerStore } from '@/Stores/customerStore';
import SearchField from '@/Pages/Customers/SearchField.vue';
import Table from '@/Pages/Customers/Table.vue';
import Pagination from '@/Pages/Customers/Pagination.vue';

let customerStore = useCustomerStore();

// PROPS
let props = defineProps( 
    {
        // elDialogVisibleProp: Boolean,//THIS MIGHT BE NOT NEEDED
        errors: Object, 
        dataFromCustomerController: Object,

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

//WATCHERS FOR PROPS: they send data received from backend to Pinia store
//Sends the customers to Pinia store, as soon arrives from backend.
watch(
    () => props.dataFromCustomerController,
    (newVal, oldVal) => {
        /**
         * Unfortunatelly, customers are coming in from backend mixed with pagination data.
         * That is what we have here in the dataFromCustomerController. We need
         * seaparted customers and separated pagination data. This will happen in computed properties.
         */
        customerStore.customers = newVal.data;

        /**
         * All pagination related data is stored here. 
         * Unfortunatelly,customers are coming in from backend mixed with pagination data.
         * That is what we have here in the dataFromCustomerController. We need
         * seaparated customers and separated pagination data. This will happen in computed properties.
         * Here. So, this is the pagination related data. And a small reminder:
         * 
         * el-pagination        Laravel ->paginate()
         * current-page	        paginationData.current_page         Where the user is currently
         * page-size	        paginationData.per_page             Number of items / page
         * total	            paginationData.total                Number of all db records
         */
        customerStore.paginationData = _.omit({...props.dataFromCustomerController}, 'data');
    },
    { immediate: true, deep: true }
);

//Sends the errors to Pinia store, as soon arrives from backend.
watch(
    () => props.errors,
    (newVal, oldVal) => {
        customerStore.errors = newVal;
    },
    { immediate: true, deep: true }
);

watch(
    () => props.sortColumnProp,
    (newVal, oldVal) => {
        customerStore.sortColumn = newVal;
    },
    { immediate: true, deep: true }
);

watch(
    () => props.sortOrderProp,
    (newVal, oldVal) => {
        customerStore.sortOrder = newVal;
    },
    { immediate: true, deep: true }
)



//METHODS

/**
 * getCustomers() is triggered by: 
 * 
 * the search button, 
 * the sorting clicks, 
 * the pagination clicks.
 * Also on input field clear/reset.
 * If enter is hit by the user.
 * 
 * It sends a request to the backend to get the customers. The backend will return the customers 
 * sorted and the pagination data. getCustomers() does not have arguments, because it uses the
 * data from data(). Because every search/sort/paginate change is in the data().
 * Now customers from this function arrive to props. There is a watcher for props, that sends customers
 * from props to Pinia store.
 */
let getCustomers = () => {
    const customers = router.get(
        '/customers',
        {
            /**
             * This is the data that we send to the backend.
             */
            searchTerm: customerStore.searchTerm,
            sortColumn: customerStore.sortColumn,
            sortOrder: customerStore.sortOrder,
            page: customerStore.paginationData.current_page,
            newItemsPerPage: customerStore.paginationData.per_page,
        }
    );
};



/**
 * PAGINATION 1
 * Example: by  default, we display 10 records per page. The user can change this to
 * 20, 30, 40... If the user for example changes the 10 to 20 records per page, then this
 * function will be triggered.
 * We set the this.paginationData.per_page to the new value.
 */
 const handleItemsPerPageChange = (newItemsPerPage: number): void => {
    data.paginationData.per_page = newItemsPerPage;
    getCustomers();
};

/**
 * PAGINATION 2
 * If there is any change, any click on the pagination element, we want to trigger this
 * pageChange() function. Now, if there is a change, then we will be moved to another
 * pagination page. Aka, there will be a new currentPage state. This new currentPage
 * will be automatically sent as an argument from the el-pagination component to Laravel
 * ->paginate().
 */
 const handleCurrentPageChange = (newCurrentPage: number) => {
    data.paginationData.current_page = newCurrentPage;
    getCustomers();
};



/**
 * This function is triggered when the user clicks on the create new customer button.
 * It sets the mode to 'create', and it sets the selectedCustomer to the customerResetValues.
 */
const handleCreate = () => {
    console.log('handleCreate()');
    customerStore.elDialogVisible = true;
    customerStore.title = 'Create new customer';
    customerStore.mode = 'create';
};

/**
 * This function is triggered when the user clicks on the edit button in the table.
 * It sets the mode to 'edit', and it sets the selectedCustomer to the customer object
 * that the user wants to edit.
 */
const handleEdit = (index, object) => {
    console.log('handleEdit()');
    customerStore.mode = 'edit';
    customerStore.elDialogVisible = true;
    customerStore.title = 'Edit customer';
    customerStore.selectedCustomer = object;
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
                    router.reload({ only: ['dataFromCustomerController'] });
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

/**
 * Sends the create or edit customer request to the backend.
 */
 const submitCustomer = () => {
    console.log('submitCustomer')
    if (customerStore.mode == 'create') {
        createCustomer();
    } else if (customerStore.mode == 'edit') {
        editCustomer();
    }
}

const createCustomer = () => {
    router.post(
        '/customers', 
        customerStore.selectedCustomer, 
        {
            onSuccess: () => {
                ElMessage({
                    message: 'Customer created successfully',
                    type: 'success',
                });
                // get customers again, so that the new customer is displayed
                router.reload({ only: ['dataFromCustomerController'] })
                customerStore.elDialogVisible = false;
            },
            onError: (errors) => {
                ElMessage.error('Oops, something went wrong while creating a new customer.')
                ElMessage(errors);
            }
        }
    )
};

const editCustomer = () => {

    router.put(
        `/customers/${customerStore.selectedCustomer.id}`, 
        customerStore.selectedCustomer,
        {
            onSuccess: () => {
                ElMessage({
                    message: 'Customer edited successfully',
                    type: 'success',
                });
                router.reload({ only: ['dataFromCustomerController'] })
                customerStore.elDialogVisible = false;
            },
            onError: (errors) => {
                ElMessage.error('Oops, something went wrong while editing a customer.')
                ElMessage(errors);
            }
        }
    )
};

</script>
