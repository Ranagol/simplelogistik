<template>
    <el-table
        :data="props.cargoOrders"
        style="width: 100%"
        @sort-change="sort"
        ref="multipleTableRef"
        stripe
        highlight-current-row
        empty-text="No result. Try with different search parameters."
        class="mt-2"
    >
        <!-- Here we want:
        1. Dynamically loop out columns of the el table
        2. Make internal_oid column a link that leads to the individual edit page. -->
        <el-table-column
            v-for="(columnName, index) in data.columns"
            :label='columnName'
            :prop='columnName'
            sortable='custom'
        >   
            <!-- Add link only for the internal_oid column, don't do this to any other column -->
            <template 
                v-if="columnName === 'internal_oid'"
                #default="scope"
            >
                <!-- This is the link, that leads to the edit page -->
                <Link
                    class="hover:underline text-blue-500"
                    :href="`/cargo-orders/${scope.row.id}/edit`"
                >{{ scope.row.internal_oid }}</Link>
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
    cargoOrders: Array,
    sortColumn: String,
    sortOrder: String,
});

const data = reactive({
    columns: [
        'id',
        'internal_oid',
        'customer_id',
        'contact_id',
        'pickup_address_id',
        'delivery_address_id',
        'description',
        'shipping_price',
        'shipping_price_netto',
        'pickup_date',
        'delivery_date',
    ],
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
    //Sending a signal to Index.vue to get the cargoOrders by the new sort order
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