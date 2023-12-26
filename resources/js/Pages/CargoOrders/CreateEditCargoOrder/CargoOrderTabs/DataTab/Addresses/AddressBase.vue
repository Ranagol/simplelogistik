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
            <Address
                v-model:address="data.cargoOrder.customer.headquarter"
                :errors="props.errors"
                :countries="props.countries"
                :mode="props.mode"
                title="Customer"
                class="grow"
            />
    
            <!-- This is just an empty divider between columns -->
            <div class="w-4"></div>
    
            <!-- PICKUP ADDRESS -->
            <Address
                v-model:address="data.cargoOrder.start_address"
                :errors="props.errors"
                :countries="props.countries"
                :mode="props.mode"
                title="Pickup"
                class="grow"
            />
    
            <!-- This is just an empty divider between columns -->
            <div class="w-4"></div>
    
            <!-- DELIVERY ADDRESS -->
            <Address
                v-model:address="data.cargoOrder.target_address"
                :errors="props.errors"
                :countries="props.countries"
                :mode="props.mode"
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
    cargoOrder: {
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
    cargoOrder: props.cargoOrder,
    showAddresses: false,
}); 

//WARNING: the emit part of the v-model here is missing!! Not done!!!!

</script>