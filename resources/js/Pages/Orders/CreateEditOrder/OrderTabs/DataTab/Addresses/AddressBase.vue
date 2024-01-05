<template>

    <div class="mt-6">
        <!-- TITLE AND SWITCH-->
        <div class="flex justify-between">
            <Title 
                title="Addresses" 
                class="mt-4 mb-2"
            />

            <el-switch
                v-model="data.showAddresses"
            ></el-switch>
        </div>

        <!-- MAIN CONTENT: ADDRESSES -->
        <div 
            v-if="data.showAddresses"
            class="flex flex-row"
        >
            
            <!-- HEADQUARTER -->
            <!-- There is no comment for the headquarter. -->
            <Address
                v-model:address="data.order.customer.headquarter"
                :errors="data.errorsHeadquarter"
                :countries="props.countries"
                :mode="props.mode"
                v-model:avis_phone="data.order.avis_customer_phone"
                title="Customer"
                class="grow"
            />
    
            <!-- This is just an empty divider between columns -->
            <div class="w-4"></div>
    
            <!-- PICKUP ADDRESS -->
            <Address
                v-model:address="data.order.pickup_address"
                :errors="data.errorsPickupAddress"
                :countries="props.countries"
                :mode="props.mode"
                v-model:avis_phone="data.order.avis_sender_phone"
                v-model:comment="data.order.p_pickup_comments"
                title="Pickup"
                class="grow"
            />
    
            <!-- This is just an empty divider between columns -->
            <div class="w-4"></div>
    
            <!-- DELIVERY ADDRESS -->
            <Address
                v-model:address="data.order.delivery_address"
                :errors="props.errors"
                :countries="props.countries"
                :mode="props.mode"
                v-model:avis_phone="data.order.avis_receiver_phone"
                v-model:comment="data.order.p_delivery_comments"
                title="Delivery"
                class="grow"
            />
    
        </div>
    </div>
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import _ from 'lodash';
import Address from './Address.vue';
import Title from '@/Shared/Title.vue';

const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
    mode: {
        type: String,
        required: true,
    },
    countries: {
        type: Array,
        required: true,
    },
});

const data = reactive({
    order: props.order,
    showAddresses: true,
    errorsHeadquarter: {},
    errorsPickupAddress: {},
    errorsDeliveryAddress: {},
}); 

/**
 * VALIDATION ERROR WATCHER
 * 
 * Every time there is a validation error, we want to do 2 things:
 * 1. sort/put the errors to the right place (headquarter, pickup, delivery) from props.errors
 * 2. name the error messages key to a multiusable string like 'first_name', instead of 'customer.headquarter.first_name'
 * 
 * Because, when they arrive from the backend, the errors look like this:
 * 
 *   customer.headquarter.company_name:"The company name field is required."
 *   customer.headquarter.first_name:"The first name field is required."
 *   --
 *   pickup_address.company_name:"The company name field is required."
 *   pickup_address.first_name:"The pickup address.first name field is required."
 *   --
 *   delivery_address.company_name:"The company name field is required."
 *   delivery_address.first_name:"The delivery address.first name field is required."
 *
 * WARNING: pickup_address.company_name IS A STRING!!!! Not a nested object.
 * console.log('watcher triggered', newVal['customer.headquarter.company_name']);
 * 
 * 
 */
watch(
    () => props.errors, 
    (newVal) => {
        console.log('watcher triggered');
        sortErrors(props.errors);
    },
    { deep: true }
);

const sortErrors = (errors) => {
    const errorsHeadquarter = {};
    const errorsPickupAddress = {};
    const errorsDeliveryAddress = {};

    _.forEach(errors, (value, key) => {
        if (key.includes('customer.headquarter')) {
            errorsHeadquarter[key] = value;
        } else if (key.includes('pickup_address')) {
            errorsPickupAddress[key] = value;
        } else if (key.includes('delivery_address')) {
            errorsDeliveryAddress[key] = value;
        }
    });

};




</script>