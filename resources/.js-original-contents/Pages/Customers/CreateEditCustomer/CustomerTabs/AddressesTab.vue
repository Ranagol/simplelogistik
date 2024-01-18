<template>
    <!-- <pre>{{ JSON.stringify(data.customer, null, 2) }}</pre> -->

    <!-- TITLE -->
    <h1
        class="font-semibold text-xl text-gray-500 leading-tight"
    >Addresses that belong to the customer</h1>

    <!-- SEARCH FIELD -->
    <div
        class="w-1/4 mt-4"
    >
        <el-input
            v-model="data.searchTerm"
            placeholder="Filter addresses belonging to the customer"
            @input="filterAddresses"
        />
    </div>
    
    <!-- TABLE OF ADDRESSES BELONGING TO THE CUSTOMER (FILTERED) -->
    <AddressTable
        :addresses="data.filteredAddresses"
    />
    
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import AddressTable from '@/Pages/Addresses/IndexAddress/AddressTable.vue';
import _ from 'lodash';

let props = defineProps({
    modelValue: {
        type: Object,
        required: true
    }
});

let data = reactive({

    /**
     * This is the customer object that we get from the parent CreateEditBase component.
     */
    customer: props.modelValue,

    /**
     * This is the search term that the user types in the search field.
     */
    searchTerm: '',

    /**
     * We want to filter our the customer's addresses. This is in the data.customer.contact_addresses.
     * Which is an object. We must convert this object to an array. We do this with the lodash 
     * values() function.
     * This must be a new object, because we don't want to mutate the original. Hence the {...} trick.
     * So the addresses will become an array of address objects. This is what we want to filter.
     */
    addresses: _.values({...props.modelValue.contact_addresses}),

    /**
     * This here contains the filtered addresses. This is what we send to the el-table.
     */
    filteredAddresses: []
});

/**
 * Does the address filtering. This is triggered by the @input event of the search field.
 */
const filterAddresses = () => {

    data.filteredAddresses = data.addresses.filter(address => {
        return address.street.toLowerCase().includes(data.searchTerm.toLowerCase())
        || address.city.toLowerCase().includes(data.searchTerm.toLowerCase())
        || address.first_name.toLowerCase().includes(data.searchTerm.toLowerCase())
        || address.last_name.toLowerCase().includes(data.searchTerm.toLowerCase());
    });

};

/**
 * This does the customer data synchronization with the parent CreateEditBase component. With
 * v-model magic. This is not sending a signal for saving the customer! Just the customer.
 */
const emit = defineEmits(['update:modelValue']);
function handleChange(){
    emit('update:modelValue', data.customer);
}

/**
 * Problem: at the very beginning the filteredAddresses is empty. So the table is empty. To avoid
 * this, we trigger the filtering at the very beginning. With this onMounted() hook.
 */
onMounted(() => {
    filterAddresses();
});

</script>

<style scoped>
</style>