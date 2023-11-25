<template>
    <el-pagination
        v-model:current-page="customerStore.paginationData.current_page"
        v-model:page-size="customerStore.paginatcustomerStoreper_page"
        :total="customerStore.paginationData.total"
        :page-sizes="[5, 10, 15, 20]"
        layout="total, sizes, prev, pager, next, jumper"
        @size-change="handleItemsPerPageChange"
        @current-change="handleCurrentPageChange"
    />
    
</template>

<script lang="ts" setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import { router} from '@inertiajs/vue3';//for sending requests;

const emit = defineEmits(['getCustomers']);

/**
 * PAGINATION 1
 * Example: by  default, we display 10 records per page. The user can change this to
 * 20, 30, 40... If the user for example changes the 10 to 20 records per page, then this
 * function will be triggered.
 * We set the this.paginationData.per_page to the new value.
 */
 const handleItemsPerPageChange = (newItemsPerPage: number): void => {
    customerStore.paginationData.per_page = newItemsPerPage;
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
    customerStore.paginationData.current_page = newCurrentPage;
    getCustomers();
};

function getCustomers() {
    emit('getCustomers');
}

</script>

<style scoped>
</style>
