<template>
    <Head title="Address" />

    <Card>
        <h1>Addresses</h1>

        <SearchField
            placeholder="Search addresses..."
            :store="addressStore"
            @getData="getData"
            createButtonText="Create new address"
            @handleCreate="handleCreate"
        />

        <!-- CREATE NEW ADDRESS POPUP -->
        <Popup
            @submit="submit"
            :store="addressStore"
        >
            <CreateEditAddress
                @submit="submit"
            />
        </Popup>

        <!-- ADDRESSES TABLE -->
        <Table
            @getData="getData"
            @handleEdit="handleEdit"
            @handleDelete="handleDelete"
            :tableColumns="data.addressTableColumns"
            :store="addressStore"
            warningItem="first_name"
            batchDeleteUrl="/addresses-batch-delete"
            modelSingular="address"
            modelPlural="addresses"
            selectedObjects="selectedAddresses"
        />

        <!-- PAGINATION -->
        <Pagination
            @getData="getData"
            :store="addressStore"
        />
    </Card>

</template>

<script lang="ts" setup>
import { TmsAddress } from '@/types/model_to_type';
import Card from '@/Shared/Card.vue';
import _ from 'lodash';
import Popup from '@/Shared/Popup.vue';
import { router } from '@inertiajs/vue3'
import { reactive, computed, watch, onMounted, nextTick, ref } from 'vue';
import { ElMessage, ElMessageBox, ElTable } from 'element-plus';
import { useAddressStore } from '@/Stores/addressStore';
import SearchField from '@/Shared/SearchField.vue';
import Table from '@/Shared/Table.vue';
import Pagination from '@/Shared/Pagination.vue';
import CreateEditAddress from '@/Pages/Addresses/CreateEditAddress.vue';

let addressStore = useAddressStore();

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
//Sends the addresses to Pinia store, as soon arrives from backend.
watch(
    () => props.dataFromController,
    (newVal: object, oldVal: object): void => {
        /**
         * Unfortunatelly, addresses are coming in from backend mixed with pagination data.
         * That is what we have here in the dataFromController. We need
         * seaparted addresses and separated pagination data. This will happen in computed properties.
         */
        addressStore.addresses = newVal.data;

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
        addressStore.paginationData = _.omit({...props.dataFromController}, 'data');
    },
    { immediate: true, deep: true }
);

//Sends the errors to Pinia store, as soon arrives from backend.
watch(
    () => props.errors,
    (newVal: object, oldVal: object): void => {
        addressStore.errors = newVal;
    },
    { immediate: true, deep: true }
);

watch(
    () => props.sortColumnProp,
    (newVal: string, oldVal: string): void => {
        addressStore.sortColumn = newVal;
    },
    { immediate: true, deep: true }
);

watch(
    () => props.sortOrderProp,
    (newVal: string, oldVal: string): void => {
        addressStore.sortOrder = newVal;
    },
    { immediate: true, deep: true }
);

let data = reactive({
    addressTableColumns: [
        {
            label: 'Id',
            prop: 'id',
            sortable: 'custom',
            width: '70px',
        },
        {
            label: 'First name',
            prop: 'first_name',
            sortable: 'custom',
        },
        {
            label: 'Last name',
            prop: 'last_name',
            sortable: 'custom',
        },
        {
            label: 'Street',
            prop: 'street',
            sortable: 'custom',
        },
        {
            label: 'House number',
            prop: 'house_number',
            sortable: 'custom',
        },
        // {
        //     label: 'Zip code',
        //     prop: 'zip_code',
        //     sortable: 'custom',
        // },
        {
            label: 'City',
            prop: 'city',
            sortable: 'custom',
        },
        {
            label: 'Country',
            prop: 'country',
            sortable: 'custom',
        },
        {
            label: 'State',
            prop: 'state',
            sortable: 'custom',
        },
        {
            label: 'Address type',
            prop: 'type_of_address',
            sortable: 'custom',
        },
        {
            label: 'Comment',
            prop: 'comment',
            sortable: 'custom',
        },
        // {
        //     label: 'Customer id',
        //     prop: 'customer_id',
        //     sortable: 'custom',
        // },
        // {
        //     label: 'Forwarder id',
        //     prop: 'forwarder_id',
        //     sortable: 'custom',
        // },
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
 * It sends a request to the backend to get the addresses. The backend will return the addresses 
 * sorted and the pagination data. getData() does not have arguments, because it uses the
 * data from data(). Because every search/sort/paginate change is in the data().
 * Now addresses from this function arrive to props. There is a watcher for props, that sends addresses
 * from props to Pinia store.
 */
let getData = (): void => {
    const addresses = router.get(
        '/addresses',
        {
            /**
             * This is the data that we send to the backend.
             */
            searchTerm: addressStore.searchTerm as string,
            sortColumn: addressStore.sortColumn as string,
            sortOrder: addressStore.sortOrder as string,
            page: addressStore.paginationData.current_page as string,
            newItemsPerPage: addressStore.paginationData.per_page as string,
        }
    );
};

/**
 * This function is triggered when the user clicks on the create new address button.
 * It sets the mode to 'create', and it sets the selectedAddress to the customerResetValues.
 */
const handleCreate = () => {
    console.log('handleCreate()');
    addressStore.elDialogVisible = true;
    addressStore.title = 'Create new address';
    addressStore.mode = 'create';
};

/**
 * This function is triggered when the user clicks on the edit button in the table.
 * It sets the mode to 'edit', and it sets the selectedAddress to the address object
 * that the user wants to edit.
 */
const handleEdit = (index, object) => {
    console.log('handleEdit()');
    addressStore.mode = 'edit';
    addressStore.elDialogVisible = true;
    addressStore.title = 'Edit address';
    addressStore.selectedAddress = object;
};

/**
 * Sends the delete address request to the backend.
 */
const handleDelete = (index, object) => {

    // Asks for confirmation message, for deleting the address.
    ElMessageBox.confirm(
        `Address for  ${object.first_name} ${object.last_name} will be deleted. Continue?`,
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
            `/addresses/${object.id}`,
            {
                onSuccess: () => {
                    ElMessage({
                        message: 'Address deleted successfully',
                        type: 'success',
                    });
                    router.reload({ only: ['dataFromController'] });
                },
                onError: (errors) => {
                    ElMessage.error('Oops, something went wrong while deleting a address.')
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
 * Sends the create or edit address request to the backend.
 */
 const submit = () => {
    console.log('submit in Index triggered')
    if (addressStore.mode == 'create') {
        createAddress();
    } else if (addressStore.mode == 'edit') {
        editAddress();
    }
}

const createAddress = () => {
    console.log('createAddress() triggered');
    router.post(
        '/addresses', 
        addressStore.selectedAddress, 
        {
            onSuccess: () => {
                ElMessage({
                    message: 'Address created successfully',
                    type: 'success',
                });
                // get addresses again, so that the new address is displayed
                router.reload({ only: ['dataFromController'] })
                addressStore.elDialogVisible = false;
            },
            onError: (errors) => {
                ElMessage.error('Oops, something went wrong while creating a new address.')
                ElMessage(errors);
            }
        }
    )
};

const editAddress = () => {

    router.put(
        `/addresses/${addressStore.selectedAddress.id}`, 
        addressStore.selectedAddress,
        {
            onSuccess: () => {
                ElMessage({
                    message: 'Address edited successfully',
                    type: 'success',
                });
                router.reload({ only: ['dataFromController'] })
                addressStore.elDialogVisible = false;
            },
            onError: (errors) => {
                ElMessage.error('Oops, something went wrong while editing a address.')
                ElMessage(errors);
            }
        }
    )
};

</script>
