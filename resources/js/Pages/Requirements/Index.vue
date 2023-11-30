<template>
    <Head title="Requirement" />

    <Card>
        <h1>Requirements</h1>

        <SearchField
            placeholder="Search requirements..."
            :store="requirementStore"
            @getData="getData"
            createButtonText="Create new requirement"
            @handleCreate="handleCreate"
        />

        <!-- CREATE NEW REQUIREMENT POPUP -->
        <Popup
            @submit="submit"
            :store="requirementStore"
        >
            <CreateEditRequirement
                @submit="submit"
            />
        </Popup>

        <!-- REQUIREMENTS TABLE -->
        <Table
            @getData="getData"
            @handleEdit="handleEdit"
            @handleDelete="handleDelete"
            :tableColumns="data.tableColumns"
            :store="requirementStore"
            warningItem="name"
            batchDeleteUrl="/requirements-batch-delete"
            modelSingular="requirement"
            modelPlural="requirements"
            selectedObjects="selectedVehicles"
        />

        <!-- PAGINATION -->
        <Pagination
            @getData="getData"
            :store="requirementStore"
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
import { useRequirementStore } from '@/Stores/requirementStore';
import SearchField from '@/Shared/SearchField.vue';
import Table from '@/Shared/Table.vue';
import Pagination from '@/Shared/Pagination.vue';
import CreateEditRequirement from '@/Pages/Requirements/CreateEditRequirement.vue';

let requirementStore = useRequirementStore();

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
//Sends the requirements to Pinia store, as soon arrives from backend.
watch(
    () => props.dataFromController,
    (newVal) => {
        /**
         * Unfortunatelly, requirements are coming in from backend mixed with pagination data.
         * That is what we have here in the dataFromController. We need
         * seaparted requirements and separated pagination data. This will happen in computed properties.
         */
        requirementStore.requirements = newVal.data;

        /**
         * All pagination related data is stored here. 
         * Unfortunatelly,requirements are coming in from backend mixed with pagination data.
         * That is what we have here in the dataFromController. We need
         * seaparated requirements and separated pagination data. This will happen in computed properties.
         * Here. So, this is the pagination related data. And a small reminder:
         * 
         * el-pagination        Laravel ->paginate()
         * current-page	        paginationData.current_page         Where the user is currently
         * page-size	        paginationData.per_page             Number of items / page
         * total	            paginationData.total                Number of all db records
         */
        if (props.dataFromController) {
            requirementStore.paginationData = _.omit({...props.dataFromController}, 'data');
        }
    },
    { immediate: true, deep: true }
);

//Sends the errors to Pinia store, as soon arrives from backend.
watch(
    () => props.errors,
    (newVal) => {
        requirementStore.errors = newVal;
    },
    { immediate: true, deep: true }
);

watch(
    () => props.sortColumnProp,
    (newVal) => {
        requirementStore.sortColumn = newVal;
    },
    { immediate: true }
);

watch(
    () => props.sortOrderProp,
    (newVal) => {
        requirementStore.sortOrder = newVal;
    },
    { immediate: true }
);

let data = reactive({
    tableColumns: [
        {
            prop: 'id',
            label: 'Id',
            sortable: 'custom'
        },
        {
            prop: 'name',
            label: 'Name',
            sortable: 'custom'
        },
        {
            prop: 'remarks',
            label: 'Remarks',
            sortable: 'custom'
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
 * It sends a request to the backend to get the requirements. The backend will return the requirements 
 * sorted and the pagination data. getData() does not have arguments, because it uses the
 * data from data(). Because every search/sort/paginate change is in the data().
 * Now requirements from this function arrive to props. There is a watcher for props, that sends requirements
 * from props to Pinia store.
 */
let getData = () => {
    const requirements = router.get(
        '/requirements',
        {
            /**
             * This is the data that we send to the backend.
             */
            searchTerm: requirementStore.searchTerm,
            sortColumn: requirementStore.sortColumn,
            sortOrder: requirementStore.sortOrder,
            page: requirementStore.paginationData.current_page,
            newItemsPerPage: requirementStore.paginationData.per_page,
        }
    );
};

/**
 * This function is triggered when the user clicks on the create new requirement button.
 * It sets the mode to 'create', and it sets the selectedRequirement to the customerResetValues.
 */
const handleCreate = () => {
    console.log('handleCreate()');
    requirementStore.elDialogVisible = true;
    requirementStore.title = 'Create new requirement';
    requirementStore.mode = 'create';
};

/**
 * This function is triggered when the user clicks on the edit button in the table.
 * It sets the mode to 'edit', and it sets the selectedRequirement to the requirement object
 * that the user wants to edit.
 */
const handleEdit = (index, object) => {
    console.log('handleEdit() and this is the index: ', index);
    requirementStore.mode = 'edit';
    requirementStore.elDialogVisible = true;
    requirementStore.title = 'Edit requirement';
    requirementStore.selectedRequirement = object;
};

/**
 * Sends the delete requirement request to the backend.
 */
const handleDelete = (index, object) => {

    // Asks for confirmation message, for deleting the requirement.
    ElMessageBox.confirm(
        `Requirement  ${object.name} will be deleted. Continue?`,
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
            `/requirements/${object.id}`,
            {
                onSuccess: () => {
                    ElMessage({
                        message: 'Requirement deleted successfully',
                        type: 'success',
                    });
                    router.reload({ only: ['dataFromController'] });
                },
                onError: (errors) => {
                    ElMessage.error('Oops, something went wrong while deleting a requirement.')
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
 * Sends the create or edit requirement request to the backend.
 */
 const submit = () => {
    console.log('submit in Index triggered')
    if (requirementStore.mode == 'create') {
        create();
    } else if (requirementStore.mode == 'edit') {
        edit();
    }
}

const create = () => {
    console.log('create() triggered');
    router.post(
        '/requirements', 
        requirementStore.selectedRequirement, 
        {
            onSuccess: () => {
                ElMessage({
                    message: 'Requirement created successfully',
                    type: 'success',
                });
                // get requirements again, so that the new requirement is displayed
                router.reload({ only: ['dataFromController'] })
                requirementStore.elDialogVisible = false;
            },
            onError: (errors) => {
                ElMessage.error('Oops, something went wrong while creating a new requirement.')
                ElMessage(errors);
            }
        }
    )
};

const edit = () => {

    router.put(
        `/requirements/${requirementStore.selectedRequirement.id}`, 
        requirementStore.selectedRequirement,
        {
            onSuccess: () => {
                ElMessage({
                    message: 'Requirement edited successfully',
                    type: 'success',
                });
                router.reload({ only: ['dataFromController'] })
                requirementStore.elDialogVisible = false;
            },
            onError: (errors) => {
                ElMessage.error('Oops, something went wrong while editing a requirement.')
                ElMessage(errors);
            }
        }
    )
};

</script>
