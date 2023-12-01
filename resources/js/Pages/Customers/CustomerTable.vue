<template>
    <el-table
        :data="props.customers"
        style="width: 100%"
        @sort-change="sort"
        ref="multipleTableRef"
        stripe
        highlight-current-row
        empty-text="No result. Try with different search parameters."
        class="mt-2"
    >
        <el-table-column
            label='Customer number'
            prop='internal_cid'
            sortable='custom'
        />

        <el-table-column
            label='Company'
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

    </el-table>

</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { reactive, computed, watch, onMounted, nextTick, ref } from 'vue';

const emit = defineEmits(['getData', 'update:sortOrder', 'update:sortColumn']);

const props = defineProps({
    customers: Array,
    sortColumn: String,
    sortOrder: String,
});

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
        emit('update:sortOrder', 'desc');
    } else {
        emit('update:sortOrder', 'asc');

    }
    //Setting the sort column in data()
    emit('update:sortColumn', prop);
    //Sending a signal to Index.vue to get the customers by the new sort order
    emit('getData');
};

</script>

<style scoped>
</style>
