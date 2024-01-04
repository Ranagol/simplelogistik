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
                :errors="props.errors"
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
                :errors="props.errors"
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
    // errorsHeadquarter: {},//works with watcher
}); 









// watch(
//     () => props.errors, 
//     (newVal) => {
//         console.log('watcher triggered', newVal);
//         console.log('watcher triggered', newVal['customer.headquarter.company_name']);
//         // console.log('watcher triggered', newVal);

        

//         console.log('data.errorsHeadquarter', data.errorsHeadquarter);
//     },
//     { deep: true }
// );





</script>