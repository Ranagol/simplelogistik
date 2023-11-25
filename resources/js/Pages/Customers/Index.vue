<template>
    <Head title="Customers" />

    <Card>
        <h1>Customers</h1>

        <!-- CUSTOMERS SEARCH FIELD -->
        <el-input
            placeholder="Search customers..."
            v-model="data.searchTerm"
            clearable
            ref="searchTermRef"
            @clear="getCustomers()"
            @change="getCustomers()"
            @input="handleSearchTermChange()"
            @keyup.escape.native="clearSearchTermWithEsc()"
        />

        <!-- SEARCH BUTTON-->
        <el-button
            @click="getCustomers"
            type="primary"
        >Search</el-button>

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
        <el-table
            :data="customerStore.customers"
            style="width: 100%"
            @sort-change="sort"
            ref="multipleTableRef"
            @selection-change="handleSelectionChange"
        >
            <el-table-column
              type="selection"
              width="55"
            />

            <el-table-column
                prop="id"
                label="ID"
                width="80"
                sortable="custom"
            ></el-table-column>

            <el-table-column
                prop="company_name"
                label="Company name"
                sortable="custom"
            ></el-table-column>

            <el-table-column
                prop="name"
                label="Name"
                sortable="custom"
            ></el-table-column>

            <el-table-column
                prop="email"
                label="Email"
                sortable="custom"
            ></el-table-column>

            <el-table-column
                prop="rating"
                label="Rating"
                sortable="custom"
            ></el-table-column>

            <el-table-column
                prop="tax_number"
                label="Tax number"
                sortable="custom"
            ></el-table-column>

            <!-- SHOW/EDIT/DELETE BUTTON IN THE TABLE -->
            <el-table-column
                label="Show/Edit/Delete"
            >
                <!-- scope.$index = number of the row in table -->
                <!-- scope.row = the object in the cell -->
                <template #default="scope">

                    <!-- <el-button
                        size="small"
                        type="info"
                        @click="handleShow(scope.$index, scope.row)"
                    >Show</el-button> -->

                    <el-button
                        size="small"
                        type="warning"
                        @click="handleEdit(scope.$index, scope.row)"
                    >Edit</el-button>

                    <el-button
                        size="small"
                        type="danger"
                        @click="handleDelete(scope.$index, scope.row)"
                    >Delete</el-button>
                </template>
            </el-table-column>


        </el-table>

        <!-- BATCH DELETE BUTTONS -->
        <div class="mt-5 mb-5">
            <el-button
                type="danger"
                @click="batchDelete()"
            >Batch delete</el-button>

            <el-button
                type="info"
                @click="clearSelection()"
            >Clear batch delete selection</el-button>
        </div>

        <el-pagination
            v-model:current-page="data.paginationData.current_page"
            v-model:page-size="data.paginationData.per_page"
            :total="data.paginationData.total"
            :page-sizes="[5, 10, 15, 20]"
            layout="total, sizes, prev, pager, next, jumper"
            @size-change="handleItemsPerPageChange"
            @current-change="handleCurrentPageChange"
        />
    </Card>

</template>

<script lang="ts" setup>
import { Customer } from '@/types/models/Customer';
import Card from '@/Shared/Card.vue';
import Pagination from '@/Shared/Pagination.vue';
import _ from 'lodash';
import Popup from '@/Shared/Popup.vue';
import { router } from '@inertiajs/vue3'
import { reactive, computed, watch, onMounted, nextTick, ref } from 'vue';
import { ElMessage, ElMessageBox, ElTable } from 'element-plus';
import { useCustomerStore } from '@/Stores/customerStore';

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
        // customers: props.dataFromCustomerController.data || [] as Customer[],//TODO why is this erroring TS?
        customerStore.customers = newVal.data;
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

//DATA
let data = reactive({
    
    //search by text
    searchTerm: props.searchTermProp,

    //sort in el-table
    sortOrder: props.sortOrderProp,
    sortColumn: props.sortColumnProp,

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
    paginationData: _.omit({...props.dataFromCustomerController}, 'data'),
    title: '',
    customerResetValues: {
        company_name: '',
        name: '',
        email: '',
        rating: '',
        tax_number: '',
        internal_cid: '',
    },

    /**
     * The selected customers are stored here. This is an array of Customer objects.
     */
    selectedCustomers: [] as Customer[],
});


//BATCH DELETE
/**
 * The multipleTableRef ref is created to hold a reference to the el-table component. This allows 
 * the toggleSelection method to call methods on the el-table component.
 */
const multipleTableRef = ref<InstanceType<typeof ElTable>>()

//Simply clears the selection. clearSelection() is a method on the el-table component.
const clearSelection = () => {
    multipleTableRef.value!.clearSelection()
}

/**
 * Will receive an array of users from @selection-change="handleSelectionChange", by default.
 * Will store these users in data.selectedCustomers.
 */
const handleSelectionChange = (selectedCustomersArray: []) => {
    data.selectedCustomers = selectedCustomersArray
    console.log(data.selectedCustomers)
}

/**
 * Deletes multiple selected customers at the same time.
 */
const batchDelete = () => {
    console.log('batchDelete()')
    console.log(data.selectedCustomers)
    //Here we extract the selected customers' ids, and store them in an array.
    const customerIds = data.selectedCustomers.map((customer) => customer.id)
    const customerCompanyNames = data.selectedCustomers.map((customer) => customer.company_name)
    let stringOfNames = '<br>'
    customerCompanyNames.forEach((customerCompanyName) => {
        console.log(customerCompanyName)
        stringOfNames += customerCompanyName + '<br>'
    })

    // Asks for confirmation message, for deleting the customer.
    ElMessageBox.confirm(
        'The selected customers will be deleted:' + stringOfNames + 'Continue?',
        'Warning',
        {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning',
            dangerouslyUseHTMLString: true,
        }
    )
    .then(() => {
        //If the deleting wish is confirmed, then we send the delete request to the backend.
        router.post(
            '/customers-batch-delete',
            {
                customerIds: customerIds//customers with these ids will be deleted
            },
            {
                onSuccess: () => {
                    ElMessage({
                        message: 'Customer deleted successfully',
                        type: 'success',
                    });
                    router.reload({ only: ['dataFromCustomerController'] });
                },
                onError: (errors) => {
                    ElMessage.error('Oops, something went wrong during batch delete.')
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
}

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
            searchTerm: data.searchTerm,
            sortColumn: data.sortColumn,
            sortOrder: data.sortOrder,
            page: data.paginationData.current_page,
            newItemsPerPage: data.paginationData.per_page,
        }
    );
};

/**
 * SORTING
 * sort() is activated by the main table header sort arrows. 
 * Problem: el-table returns ascending or descending, however my backend works with 
 * 'asc' or 'desc'. So here we also transform the ascending/descending to asc/desc.
 */
 interface Sort {
    prop: string;
    order: string;
}
const sort = ( { prop, order }: Sort): void => {

    //Setting the sort order in data()
    if (order === 'descending') {
        data.sortOrder = 'desc';
    } else {
        data.sortOrder = 'asc';
    }
    //Setting sortColumn ind data()
    data.sortColumn = prop;
    getCustomers();
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
 * INPUT FIELD
 * For every typed letter in the input field, this function will get the filtered customers,
 * again and again.
 * This is how we can throttle this function: 
 * https://www.geeksforgeeks.org/lodash-_-throttle-method/
 */
const handleSearchTermChange = () => {
    getCustomers();
};

/**
 * INPUT FIELD
 * When ESC is hit, we want to clear the search term, and get all customers again.
 */
 const clearSearchTermWithEsc = () => {
    data.searchTerm = '';
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
    customerStore.selectedCustomer = data.customerResetValues;//empties customer values
};

/**
 * This function is triggered when the user clicks on the show button in the table.
 * It sets the mode to 'show', and it sets the selectedCustomer to the customer object
 * that the user wants to show.
 */
// const handleShow = (index, object) => {
//     customerStore.elDialogVisible = true;
//     customerStore.title = 'Show customer';
//     customerStore.mode = 'show';
//     customerStore.selectedCustomer = object;
// };

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
    //Editing customer in Pinia store
    customerStore.editCustomer();
    //Editing customer in db

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
  
let searchTermRef = ref(null);
onMounted(() => {

    /**
     * INPUT FIELD
     * When the page is loaded, we want to focus on the search input.
     * So we use the mounted() lifecycle hook, and we focus on the search input.
     */
    nextTick(() => {
        searchTermRef.value.focus();
    });
});

</script>
