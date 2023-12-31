<template>

    <el-table
        :data="props.orders"
        style="width: 100%"
        @sort-change="sort"
        ref="multipleTableRef"
        stripe
        highlight-current-row
        empty-text="No result. Try with different search parameters."
        class="mt-2"
        border
        show-overflow-tooltip
        scrollbar-always-on
    >
        <el-table-column
            width="100"
            prop="id"
            label="ID"
            sortable="custom"
        ></el-table-column>


        <el-table-column
            width="150"
            prop="p_order_number"
            label="Order number"
            sortable="custom"
        >
            <template 
                #default="scope"
            >
                <!-- This is the link, that leads to the edit page -->
                <Link
                    class="hover:underline text-blue-500"
                    :href="`/orders/${scope.row.id}/edit`"
                >{{ scope.row.p_order_number }}</Link>

            </template>

        </el-table-column>

        <el-table-column
            width="250"
            prop="p_order_status"
            label="Order status"
        >Pull from orderHistories
        </el-table-column>

        <el-table-column
            width="250"
            prop="type_of_transport"
            label="Type of transport"
            sortable="custom"  
        ></el-table-column>

        <!-- *********************** -->
        <el-table-column
            width="150"
            prop="created_at"
            label="Order date"
            sortable="custom"
        >
            <template #default="scope">
                {{ useDateFormatter(scope.row.created_at) }}
            </template>
        
        </el-table-column>

        <el-table-column
            width="350"
            label="Pickup date period"
        >
            <template #default="scope">
                {{ useDateTimeFormatter(scope.row.p_pickup_date_from) }} 
                - {{ useDateTimeFormatter(scope.row.p_pickup_date_to) }}
            </template>
        </el-table-column>

        <el-table-column
            width="350"
            label="Delivery date period"
        >
            <template #default="scope">
                {{ useDateTimeFormatter(scope.row.p_delivery_date_from) }} 
                - {{ useDateTimeFormatter(scope.row.p_delivery_date_to) }}
            </template>
        </el-table-column>

        <el-table-column
            width="250"
            label="Pickup address"
        >
            <template #default="scope">
                code**  {{ scope.row.start_address.city }}
            </template>
        </el-table-column>

        <el-table-column
            width="250"
            label="Delivery address"
        >
            <template #default="scope">
                code**  {{ scope.row.target_address.city }}
            </template>
        </el-table-column>
        
        <el-table-column
            width="350"
            label="Description"
            sortable="custom"
            prop="p_description_of_transport"
        ></el-table-column>
        
        <el-table-column
            width="150"
            label="Price gross"
            sortable="custom"
            prop="p_calculated_transport_price"
        ></el-table-column>

        <!-- <el-table-column
            width="400"
            label="Parcels"
        >
            <template #default="scope">
                <div
                    v-for="(parcel, index) in scope.row.parcels"
                    v-if="scope.row.parcels.length > 0"
                    :key="index"
                >   
                    Parcell {{ index + 1 }}:
                    {{parcel.p_height}}
                    x{{ parcel.p_width }}
                    x{{ parcel.p_length }}
                    cm - {{ parcel.p_weight }} kg
                
                </div>
                <div
                    v-else
                >No parcel data.</div>
            </template>
        </el-table-column> -->

        <!-- <el-table-column
            width="200"
            label="Value of goods"
            sortable="custom"
            prop="p_value_of_goods"
        ></el-table-column>-->

        <el-table-column
            width="300"
            label="Pickup contact"
        >
            <template #default="scope">
                {{ scope.row.start_address.first_name }} 
                {{ scope.row.start_address.last_name }}
                {{ scope.row.avis_receiver_phone }}

            </template>
        </el-table-column> 

        <el-table-column
            width="250"
            label="Delivery contact"
        >
            <template #default="scope">
                {{ scope.row.target_address.first_name }} 
                {{ scope.row.target_address.last_name }}
                {{ scope.row.avis_receiver_phone }}
            </template>
        </el-table-column>

        <el-table-column
            width="350"
            label="Customer reference"
            sortable="custom"
            prop="customer_reference"
        ></el-table-column>
        
    </el-table>

</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { reactive, computed, watch, onMounted, nextTick, ref } from 'vue';
import _ from 'lodash';
import { useDateFormatter } from '@/Use/useDateFormatter.js';
import { useDateTimeFormatter } from '@/Use/useDateTimeFormatter.js';


const emit = defineEmits(['getData', 'update:sortOrder', 'update:sortColumn']);

const props = defineProps({
    orders: Array,
    sortColumn: String,
    sortOrder: String,
});

const data = reactive({
    columns: [
        'id',
        'p_order_number',
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
 * columnTextShortener() is used to shorten the text in the table
 */
const columnTextShortener = (text) =>{
    return text;
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
        emit('update:sortOrder', 'desc');
    } else {
        emit('update:sortOrder', 'asc');

    }
    //Setting the sort column in data()
    emit('update:sortColumn', prop);
    //Sending a signal to Index.vue to get the orders by the new sort order
    emit('getData');
};



</script>

<style scoped>
</style>@/Use/useDateFormatter.js