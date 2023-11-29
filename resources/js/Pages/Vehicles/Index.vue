<template>
    <Head title="Vehicle" />

    <Card>
        <h1>Vehicles</h1>

        <SearchField
            placeholder="Search vehicles..."
            :store="vehicleStore"
            @getData="getData"
            createButtonText="Create new vehicle"
            @handleCreate="handleCreate"
        />

        <!-- CREATE NEW VEHICLE POPUP -->
        <Popup
            @submit="submit"
            :store="vehicleStore"
        >
            <CreateEditVehicle
                @submit="submit"
            />
        </Popup>

        <!-- VEHICLES TABLE -->
        <Table
            @getData="getData"
            @handleEdit="handleEdit"
            @handleDelete="handleDelete"
            :tableColumns="data.tableColumns"
            :store="vehicleStore"
            warningItem="name"
            batchDeleteUrl="/vehicles-batch-delete"
            modelSingular="vehicle"
            modelPlural="vehicles"
            selectedObjects="selectedVehicles"
        />

        <!-- PAGINATION -->
        <Pagination
            @getData="getData"
            :store="vehicleStore"
        />
    </Card>

</template>

<script lang="ts" setup>
import { TmsVehicle } from '@/types/model_to_type';
import Card from '@/Shared/Card.vue';
import _ from 'lodash';
import Popup from '@/Shared/Popup.vue';
import { router } from '@inertiajs/vue3'
import { reactive, computed, watch, onMounted, nextTick, ref } from 'vue';
import { ElMessage, ElMessageBox, ElTable } from 'element-plus';
import { useVehicleStore } from '@/Stores/vehicleStore';
import SearchField from '@/Shared/SearchField.vue';
import Table from '@/Shared/Table.vue';
import Pagination from '@/Shared/Pagination.vue';
import CreateEditVehicle from '@/Pages/Vehicles/CreateEditVehicle.vue';

let vehicleStore = useVehicleStore();

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
//Sends the vehicles to Pinia store, as soon arrives from backend.
watch(
    () => props.dataFromController,
    (newVal: object, oldVal: object): void => {
        /**
         * Unfortunatelly, vehicles are coming in from backend mixed with pagination data.
         * That is what we have here in the dataFromController. We need
         * seaparted vehicles and separated pagination data. This will happen in computed properties.
         */
        vehicleStore.vehicles = newVal.data;

        /**
         * All pagination related data is stored here. 
         * Unfortunatelly,vehicles are coming in from backend mixed with pagination data.
         * That is what we have here in the dataFromController. We need
         * seaparated vehicles and separated pagination data. This will happen in computed properties.
         * Here. So, this is the pagination related data. And a small reminder:
         * 
         * el-pagination        Laravel ->paginate()
         * current-page	        paginationData.current_page         Where the user is currently
         * page-size	        paginationData.per_page             Number of items / page
         * total	            paginationData.total                Number of all db records
         */
        vehicleStore.paginationData = _.omit({...props.dataFromController}, 'data');
    },
    { immediate: true, deep: true }
);

//Sends the errors to Pinia store, as soon arrives from backend.
watch(
    () => props.errors,
    (newVal: object, oldVal: object): void => {
        vehicleStore.errors = newVal;
    },
    { immediate: true, deep: true }
);

watch(
    () => props.sortColumnProp,
    (newVal: string, oldVal: string): void => {
        vehicleStore.sortColumn = newVal;
    },
    { immediate: true, deep: true }
);

watch(
    () => props.sortOrderProp,
    (newVal: string, oldVal: string): void => {
        vehicleStore.sortOrder = newVal;
    },
    { immediate: true, deep: true }
);

let data = reactive({
    tableColumns: [
        {
            prop: 'id',
            label: 'Id',
            sortable: 'custom',
        },
        {
            prop: 'name',
            label: 'Name',
            sortable: 'custom',
        },
        {
            prop: 'max_weight',
            label: 'Max weight',
            sortable: 'custom',
        },
        {
            prop: 'max_pickup_weight',
            label: 'Max pickup weight',
            sortable: 'custom',
        },
        {
            prop: 'max_pickup_width',
            label: 'Max pickup width',
            sortable: 'custom',
        },
        {
            prop: 'max_pickup_height',
            label: 'Max pickup height',
            sortable: 'custom',
        },
        {
            prop: 'max_pickup_length',
            label: 'Max pickup length',
            sortable: 'custom',
        },
        {
            prop: 'vehicle_type',
            label: 'Vehicle type',
            sortable: 'custom',
        },
        {
            prop: 'plate_number',
            label: 'Plate number',
            sortable: 'custom',
        },
        {
            prop: 'forwarder_id',
            label: 'Forw. id',
            sortable: 'custom',
        },
        {
            prop: 'address_id',
            label: 'Address id',
            sortable: 'custom',
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
 * It sends a request to the backend to get the vehicles. The backend will return the vehicles 
 * sorted and the pagination data. getData() does not have arguments, because it uses the
 * data from data(). Because every search/sort/paginate change is in the data().
 * Now vehicles from this function arrive to props. There is a watcher for props, that sends vehicles
 * from props to Pinia store.
 */
let getData = (): void => {
    const vehicles = router.get(
        '/vehicles',
        {
            /**
             * This is the data that we send to the backend.
             */
            searchTerm: vehicleStore.searchTerm as string,
            sortColumn: vehicleStore.sortColumn as string,
            sortOrder: vehicleStore.sortOrder as string,
            page: vehicleStore.paginationData.current_page as string,
            newItemsPerPage: vehicleStore.paginationData.per_page as string,
        }
    );
};

/**
 * This function is triggered when the user clicks on the create new vehicle button.
 * It sets the mode to 'create', and it sets the selectedVehicle to the customerResetValues.
 */
const handleCreate = () => {
    console.log('handleCreate()');
    vehicleStore.elDialogVisible = true;
    vehicleStore.title = 'Create new vehicle';
    vehicleStore.mode = 'create';
};

/**
 * This function is triggered when the user clicks on the edit button in the table.
 * It sets the mode to 'edit', and it sets the selectedVehicle to the vehicle object
 * that the user wants to edit.
 */
const handleEdit = (index, object) => {
    console.log('handleEdit()');
    vehicleStore.mode = 'edit';
    vehicleStore.elDialogVisible = true;
    vehicleStore.title = 'Edit vehicle';
    vehicleStore.selectedVehicle = object;
};

/**
 * Sends the delete vehicle request to the backend.
 */
const handleDelete = (index, object) => {

    // Asks for confirmation message, for deleting the vehicle.
    ElMessageBox.confirm(
        `Vehicle  ${object.name} ${object.plate_number} will be deleted. Continue?`,
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
            `/vehicles/${object.id}`,
            {
                onSuccess: () => {
                    ElMessage({
                        message: 'Vehicle deleted successfully',
                        type: 'success',
                    });
                    router.reload({ only: ['dataFromController'] });
                },
                onError: (errors) => {
                    ElMessage.error('Oops, something went wrong while deleting a vehicle.')
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
 * Sends the create or edit vehicle request to the backend.
 */
 const submit = () => {
    console.log('submit in Index triggered')
    if (vehicleStore.mode == 'create') {
        create();
    } else if (vehicleStore.mode == 'edit') {
        edit();
    }
}

const create = () => {
    console.log('create() triggered');
    router.post(
        '/vehicles', 
        vehicleStore.selectedVehicle, 
        {
            onSuccess: () => {
                ElMessage({
                    message: 'Vehicle created successfully',
                    type: 'success',
                });
                // get vehicles again, so that the new vehicle is displayed
                router.reload({ only: ['dataFromController'] })
                vehicleStore.elDialogVisible = false;
            },
            onError: (errors) => {
                ElMessage.error('Oops, something went wrong while creating a new vehicle.')
                ElMessage(errors);
            }
        }
    )
};

const edit = () => {

    router.put(
        `/vehicles/${vehicleStore.selectedVehicle.id}`, 
        vehicleStore.selectedVehicle,
        {
            onSuccess: () => {
                ElMessage({
                    message: 'Vehicle edited successfully',
                    type: 'success',
                });
                router.reload({ only: ['dataFromController'] })
                vehicleStore.elDialogVisible = false;
            },
            onError: (errors) => {
                ElMessage.error('Oops, something went wrong while editing a vehicle.')
                ElMessage(errors);
            }
        }
    )
};

</script>
