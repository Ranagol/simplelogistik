<template>
    <el-table
        :data="store[props.modelPlural]"
        style="width: 100%"
        @sort-change="sort"
        ref="multipleTableRef"
        @selection-change="handleSelectionChange"
        stripe
        highlight-current-row
        empty-text="No result. Try with different search parameters."
        class="mt-2"
    >
        <!-- CHECKBOX FOR BATCH DELETE -->
        <el-table-column
            type="selection"
            width="55"
        />

        <!-- LOOPED COLUMNS -->
        <el-table-column
            v-for="column in props.tableColumns"
            :key="column.prop"
            :prop="column.prop"
            :label="column.label"
            :sortable="column.sortable"
            :width="column.width ? column.width : ''"
        ></el-table-column>

        <el-table-column
            label="Id"
            prop="id"
            sortable="custom"
            width="70"
        />

        <el-table-column
            label='Internal CID'
            prop='internal_cid'
            sortable='custom'
        />

        <el-table-column
            label='Company name'
            prop='company_name'
            sortable='custom'
        >
            <template #default="scope">
                <Link
                    class="hover:underline text-blue-500"
                    :href="`/customers/${scope.row.id}/edit`"
                >{{ scope.row.company_name }}</Link>
            </template>
        </el-table-column>

        <el-table-column
            label="name"
            prop="name"
            sortable="custom"
        />

        <el-table-column
            label="Email"
            prop="email"
            sortable="custom"
        />

        <el-table-column
            label="Tax number"
            prop="tax_number"
            sortable="custom"
        />

        <el-table-column
            label="Rating"
            prop="rating"
            sortable="custom"
        />

        <!-- SHOW/EDIT/DELETE BUTTON IN THE TABLE (FIX, NOT LOOPED COLUMNS) -->
        <el-table-column
            label="Edit/Delete"
        >
            <template #default="scope">

                <!-- EDIT -->
                <el-button
                    size="small"
                    type="warning"
                    @click="handleEdit(scope.$index, scope.row)"
                >Edit</el-button>

                <!-- DELETE -->
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
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import { router} from '@inertiajs/vue3';//for sending requests;
import { ElMessage, ElMessageBox, ElTable } from 'element-plus';
import { Link } from '@inertiajs/vue3';

const emit = defineEmits(['getData', 'handleEdit', 'handleDelete']);

const props = defineProps({
    store: Object,
    company_name: String,
    batchDeleteUrl: String,
    modelSingular: String,
    modelPlural: String,
    selectedObjects: String,
    warningItem: String,
});

//BATCH DELETE
/**
 * The multipleTableRef ref is created to hold a reference to the el-table component. This allows 
 * the toggleSelection method to call methods on the el-table component.
 */
 const multipleTableRef = ref();

//Simply clears the selection for batch delete. clearSelection() is a method on the el-table component.
const clearSelection = () => {
    multipleTableRef.value && multipleTableRef.value.clearSelection();
};

/**
 * For batch delete.
 * Will receive an array of users from @selection-change="handleSelectionChange", by default.
 * Will store these users in store.selectedObjects
 */
const handleSelectionChange = (arrayOfSelectedObjects) => {
    props.store[props.selectedObjects] = arrayOfSelectedObjects;
}

/**
 * Deletes multiple selected objects at the same time.
 */
const batchDelete = () => {
    //Here we extract the selected objects' ids, and store them in an array.
    const objectIdsForBatchDeleting = props.store[props.selectedObjects].map((object) => object.id)
    //Here we extract the selected objects' company names, and store them in an array.
    const warningItemNamesForBatchDelete = props.store[props.selectedObjects].map((object) => object[props.warningItem])
    let stringOfNames = '<br>';//Here we will add the object names to a string, so that we can show them in the confirmation message.
    warningItemNamesForBatchDelete.forEach((warningItemName) => {
        console.log(warningItemName)
        stringOfNames += warningItemName + '<br>'
    })

    // Asks for confirmation message, for deleting the object.
    ElMessageBox.confirm(
        `The selected ${props.modelPlural} will be deleted: ${stringOfNames} Continue?`,
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
            props.batchDeleteUrl,//the url where we send the batch delete request
            {
                ids: objectIdsForBatchDeleting//objects with these ids will be deleted
            },
            {
                onSuccess: () => {
                    ElMessage({
                        message: `${props.modelSingular} deleted successfully`,
                        type: 'success',
                    });
                    router.reload({ only: ['dataFromController'] });
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
};

/**
 * SORTING
 * sort() is activated by the main table header sort arrows. 
 * Problem: el-table returns ascending or descending, however my backend works with 
 * 'asc' or 'desc'. So here we also transform the ascending/descending to asc/desc.
 */
const sort = ( { prop, order }) => {
    // console.log('sort triggered', prop, order);

    //Setting the sort order in data()
    if (order === 'descending') {
        props.store.sortOrder = 'desc';
    } else {
        props.store.sortOrder = 'asc';
    }
    //Setting sortColumn ind data()
    props.store.sortColumn = prop;
    getData();
};

const getData = () => {
    emit('getData');
};

const handleEdit = (index, row) => {
    emit('handleEdit', index, row);
};

const handleDelete = (index, row) => {
    emit('handleDelete', index, row);
};


</script>

<style scoped>
</style>
