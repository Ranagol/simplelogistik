<template>

    <!-- TITLE -->
    <h1
        class="text-xl font-semibold leading-tight text-gray-500"
    >Addresses that belong to the customer</h1>

    
    <!-- TABLE OF ADDRESSES BELONGING TO THE CUSTOMER (FILTERED) -->
    <!-- <AddressTable
        :addresses="props.addresses"
        /> -->
        {{props.addresses}}
    
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
// import AddressTable from '@/Pages/Addresses/IndexAddress/AddressTable.vue';
import _ from 'lodash';

let props = defineProps({

    /**
     * All the addresses that belong to this given customer.
     */
    addresses: {
        type: Array,
        required: true
    },
});

</script>

<style scoped>
</style>