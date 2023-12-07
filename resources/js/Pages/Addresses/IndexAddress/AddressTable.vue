<template>
    <el-table
        :data="props.addresses"
        style="width: 100%"
        @sort-change="sort"
        ref="multipleTableRef"
        stripe
        highlight-current-row
        empty-text="No result. Try with different search parameters."
        class="mt-2"
    >
        <el-table-column
            label='Id'
            prop='id'
            sortable='custom'
            width='80px'
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
            label="Address type"
            prop="address_type"
            sortable="custom"
            width="200px"
        >
            <template #default="scope">
                <Link
                    class="hover:underline text-blue-500"
                    :href="`/addresses/${scope.row.id}/edit`"
                >{{ scope.row.address_type }}</Link>
            </template>
        </el-table-column>

        <el-table-column
            label="Street"
            prop="street"
            sortable="custom"
            width="250px"
        />

        <el-table-column
            label="House number"
            prop="house_number"
            sortable="custom"
            width="150px"
        />

        <el-table-column
            label="Zip code"
            prop="zip_code"
            sortable="custom"
            width="150px"
        />

        <el-table-column
            label="City"
            prop="city"
            sortable="custom"
            width="150px"
        />

        <el-table-column
            label="Country"
            prop="country"
            sortable="custom"
            width="250px"
        />

        <el-table-column
            label="State"
            prop="state"
            sortable="custom"
            width="150px"
        />

        <!-- <el-table-column
            label="Type of address"
            prop="type_of_address"
            sortable="custom"
        /> -->

        <el-table-column
            label="Comment"
            prop="comment"
            sortable="custom" 
            width="300px"
        />

        <el-table-column
            label="Cust. id"
            prop="customer_id"
            sortable="custom"
            width="150px"
        />

        <el-table-column
            label="Forwarder id"
            prop="forwarder_id"
            sortable="custom"
            width="150px"
        />
    </el-table> 
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { reactive, computed, watch, onMounted, nextTick, ref } from 'vue';
import moment from 'moment';

const emit = defineEmits(['getData', 'update:sortOrder', 'update:sortColumn']);

const props = defineProps({
    addresses: Array,
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
    //Sending a signal to Index.vue to get the addresses by the new sort order
    emit('getData');
};

/**
 * FORMATTING
 * formatDate() is used to format the date in the table
 */
const formatDate = (dateString) => {
    const dateObject = moment(dateString);
    return dateObject.format('DD-MM-YYYY');
};

</script>

<style scoped>
</style>