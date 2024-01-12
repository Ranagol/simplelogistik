<template>
    <el-table
        :data="props.customers"
        style="width: 100%"
        @sort-change="sort"
        ref="multipleTableRef"
        stripe
        fit
        highlight-current-row
        empty-text="No result. Try with different search parameters."
        class="mt-2"
        header-align="right"
        border
        show-overflow-tooltip
        scrollbar-always-on
    >
        <el-table-column
            label='Id'
            prop='id'
            sortable='custom'
            width="80px"
        />

        <el-table-column
            label='C. number'
            prop='internal_id'
            sortable='custom'
            width="150px"
        >
            <template #default="scope">
                <Link
                    class="hover:underline text-blue-500"
                    :href="`/customers/${scope.row.id}/edit`"
                >{{ scope.row.internal_id }}</Link>
            </template>
        </el-table-column>

        <el-table-column
            label='Company'
            prop='company_name'
            sortable='custom'
            width="300"
        />
            
        <el-table-column
            label='Cust. type'
            prop='customer_type'
            sortable='custom'
            width="200px"
        />

        <el-table-column
            label="First name"
            prop="first_name"
            sortable="custom"
            width="150px"
        />

        <el-table-column
            label="Last name"
            prop="last_name"
            sortable="custom"
            width="150px"
        />

        <el-table-column
            label="Address"
            sortable="custom"
            width="250px"
        >
            <template #default="scope">
                {{ scope.row.headquarter[0]?.street }} 
                {{ scope.row.headquarter[0]?.house_number }}
            </template>
        </el-table-column>

        <el-table-column
            label="Zip code"
            sortable="custom"
            width="150px"
        >
            <template #default="scope">
                {{ scope.row.headquarter[0]?.zip_code }}
            </template>
        </el-table-column>

        <el-table-column
            label="City"
            sortable="custom"
            width="150px"
        >
            <template #default="scope">
                {{ scope.row.headquarter[0]?.city }}
            </template>
        </el-table-column>

        <el-table-column
            label="Email"
            prop="email"
            sortable="custom"
            width="250px"
        />

        <el-table-column
            label="Tax number"
            prop="tax_number"
            sortable="custom"
            width="150px"
        />

        <el-table-column
            label="Registration date"
            prop="created_at"
            sortable="custom"
            width="250px"
        >
            <template #default="scope">
                {{ formatDate(scope.row.created_at) }}
            </template>
        </el-table-column>

    </el-table>

</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { reactive, computed, watch, onMounted, nextTick, ref } from 'vue';
import moment from 'moment';

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

/**
 * FORMATTING
 * formatDate() is used to format the date in the table
 */
const formatDate = (dateString) => {
    const dateObject = moment(dateString);
    return dateObject.format('DD.MM.YYYY');
};

</script>

<style scoped>
</style>
