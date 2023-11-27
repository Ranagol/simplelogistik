<template>
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

<script lang="ts" setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import { router} from '@inertiajs/vue3';//for sending requests;
import { useCustomerStore } from '@/Stores/customerStore';
import { ElMessage, ElMessageBox, ElTable } from 'element-plus';

let customerStore = useCustomerStore();

const emit = defineEmits(['getCustomers', 'handleEdit', 'handleDelete']);

//BATCH DELETE
/**
 * The multipleTableRef ref is created to hold a reference to the el-table component. This allows 
 * the toggleSelection method to call methods on the el-table component.
 */
 const multipleTableRef = ref<InstanceType<typeof ElTable>>()

//Simply clears the selection. clearSelection() is a method on the el-table component.
const clearSelection = () => {
    multipleTableRef.value!.clearSelection();
}

/**
 * For batch delete.
 * Will receive an array of users from @selection-change="handleSelectionChange", by default.
 * Will store these users in customerStore.selectedCustomers.
 */
const handleSelectionChange = (selectedCustomersArray: []) => {
    customerStore.selectedCustomers = selectedCustomersArray;
}

/**
 * Deletes multiple selected customers at the same time.
 */
const batchDelete = () => {
    //Here we extract the selected customers' ids, and store them in an array.
    const customerIds = customerStore.selectedCustomers.map((customer) => customer.id)
    //Here we extract the selected customers' company names, and store them in an array.
    const customerCompanyNames = customerStore.selectedCustomers.map((customer) => customer.company_name)
    let stringOfNames = '<br>';//Here we will add the customer names to a string, so that we can show them in the confirmation message.
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
    // console.log('sort triggered', prop, order);

    //Setting the sort order in data()
    if (order === 'descending') {
        customerStore.sortOrder = 'desc';
    } else {
        customerStore.sortOrder = 'asc';
    }
    //Setting sortColumn ind data()
    customerStore.sortColumn = prop;
    getCustomers();
};

const getCustomers = () => {
    emit('getCustomers');
};

const handleEdit = (index: number, row: any) => {
    emit('handleEdit', index, row);
};

const handleDelete = (index: number, row: any) => {
    emit('handleDelete', index, row);
};


</script>

<style scoped>
</style>
