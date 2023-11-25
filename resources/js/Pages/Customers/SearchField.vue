<template>

    <!-- autofocus -->
        <!-- tabindex="1" -->
    <!-- CUSTOMERS SEARCH FIELD -->
    <el-input
        placeholder="Search customers..."
        v-model="customerStore.searchTerm"
        clearable
        
        ref="searchTermRef"
        @clear="getCustomers()"
        @change="getCustomers()"
        @input="getCustomers()"
        @keyup.escape.native="clearSearchTermWithEsc()"
    />

    <!-- SEARCH BUTTON-->
    <el-button
        @click="getCustomers"
        type="primary"
    >Search</el-button>
    
</template>

<script lang="ts" setup>
import { reactive, ref, computed, watch, onUpdated, onMounted, nextTick } from 'vue';
import { router} from '@inertiajs/vue3';//for sending requests;
import { useCustomerStore } from '@/Stores/customerStore';

let customerStore = useCustomerStore();

const emit = defineEmits(['getCustomers']);

/**
 * When ESC is hit, we want to clear the search term, and get all customers again.
 */
 const clearSearchTermWithEsc = () => {
    customerStore.searchTerm = '';
    getCustomers();
};

function getCustomers() {
    emit('getCustomers');
}


//SETTING FOCUS IN INPUT FIELD
let searchTermRef = ref(null);
onMounted(() => {

    /**
     * INPUT FIELD
     * When the page is loaded, we want to focus on the search input.
     * So we use the mounted() lifecycle hook, and we focus on the search input.
     */
    nextTick(() => {
        searchTermRef.value.focus();
    });
});

</script>

<style scoped>
</style>


