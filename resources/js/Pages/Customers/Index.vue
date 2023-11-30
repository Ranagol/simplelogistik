<template>
    <Head title="Customer" />

    <Card>
        <h1>Customers</h1>

        <SearchField
            placeholder="Search customers..."
            :store="customerStore"
            @getData="getData"
            createButtonText="Create new customer"
            @handleCreate="handleCreate"
        />

        <!-- CREATE NEW CUSTOMER POPUP -->
        <Popup
            @submit="submit"
            :store="customerStore"
        >
            <CreateEditCustomer
                @submit="submit"
            ></CreateEditCustomer>
        </Popup>

        <!-- CUSTOMERS TABLE -->
        <Table
            @getData="getData"
            @handleEdit="handleEdit"
            @handleDelete="handleDelete"
            :tableColumns="data.customerTableColumns"
            :store="customerStore"
            warningItem="company_name"
            batchDeleteUrl="/customers-batch-delete"
            modelSingular="customer"
            modelPlural="customers"
            selectedObjects="selectedCustomers"
        />

        <!-- PAGINATION -->
        <Pagination
            @getData="getData"
            :store="customerStore"
        />
    </Card>

</template>

<script setup>
import Card from '@/Shared/Card.vue';
import _ from 'lodash';
import Popup from '@/Shared/Popup.vue';
import { router } from '@inertiajs/vue3'
import { reactive, computed, watch, onMounted, nextTick, ref } from 'vue';
import { ElMessage, ElMessageBox, ElTable } from 'element-plus';
import { useCustomerStore } from '@/Stores/customerStore';
import SearchField from '@/Shared/SearchField.vue';
import Table from '@/Shared/Table.vue';
import Pagination from '@/Shared/Pagination.vue';
import CreateEditCustomer from '@/Pages/Customers/CreateEditCustomer.vue';


let customerStore = useCustomerStore();

// PROPS
let props = defineProps( 
    {
        // elDialogVisibleProp: Boolean,//THIS MIGHT BE NOT NEEDED
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

//WATCHERS FOR PROPS: they send data received from backend to Pinia store
//Sends the customers to Pinia store, as soon arrives from backend.
watch(
    () => props.dataFromController,
    (newVal, oldVal) => {
        /**
         * Unfortunatelly, customers are coming in from backend mixed with pagination data.
         * That is what we have here in the dataFromController. We need
         * seaparted customers and separated pagination data. This will happen in computed properties.
         */
        customerStore.customers = newVal.data;

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
        customerStore.paginationData = _.omit({...props.dataFromController}, 'data');
    },
    { immediate: true, deep: true }
);

//Sends the errors to Pinia store, as soon arrives from backend.
watch(
    () => props.errors,
    (newVal) => {
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
    (newVal) => {
        customerStore.sortOrder = newVal;
    },
    { immediate: true, deep: true }
);

let data = reactive({
    customerTableColumns: [
        {
            label: 'Id',
            prop: 'id',
            sortable: 'custom',
            width: '70px',
        },
        {
            label: 'Internal CID',
            prop: 'internal_cid',
            sortable: 'custom',
        },
        {
            label: 'Company name',
            prop: 'company_name',
            sortable: 'custom',
        },
        {
            label: 'Name',
            prop: 'name',
            sortable: 'custom',
        },
        {
            label: 'Email',
            prop: 'email',
            sortable: 'custom',
        },
        {
            label: 'Tax number',
            prop: 'tax_number',
            sortable: 'custom',
        },
        {
            label: 'Rating',
            prop: 'rating',
            sortable: 'custom',
            width: '100px',
        }
    ],
});


//METHODS

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
            searchTerm: customerStore.searchTerm,
            sortColumn: customerStore.sortColumn,
            sortOrder: customerStore.sortOrder,
            page: customerStore.paginationData.current_page,
            newItemsPerPage: customerStore.paginationData.per_page,
        }
    );
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

/**
 * Sends the create or edit customer request to the backend.
 */
 const submit = () => {
    console.log('submit')
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
                router.reload({ only: ['dataFromController'] })
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
                router.reload({ only: ['dataFromController'] })
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
