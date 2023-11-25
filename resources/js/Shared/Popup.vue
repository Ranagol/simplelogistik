<template>
    <el-dialog
        v-model="customerStore.elDialogVisible"
        :title=customerStore.title
        @open="handleDialogOpened"
    >
        <CreateEditCustomer
            @submitCustomer="submitCustomer"
            :key="data.componentKey"
        ></CreateEditCustomer>

    </el-dialog>
</template>

<script lang="ts" setup>
import CreateEditCustomer from '@/Pages/Customers/CreateEditCustomer.vue';
import { reactive, watch, ref } from 'vue';
import { useCustomerStore } from '@/Stores/customerStore';

let customerStore = useCustomerStore();

/**
 * This is used to refresh the el-dialog component.
 * Problem: choose customer to edit, then click cancel, and then choose another customer to edit.
 * While the app knows the correct customer to edit, the el-dialog component does not display the
 * correct customer. The only way to make it work is to change the key of the child CreateEditCustomer.vue.
 * https://michaelnthiessen.com/key-changing-technique/
 */
let handleDialogOpened = () => {
    data.componentKey += 1;
}

let data = reactive({

    /**
     * This is used to refresh the el-dialog component.
     * Problem: choose customer to edit, then click cancel, and then choose another customer to edit.
     * While the app knows the correct customer to edit, the el-dialog component does not display the
     * correct customer. The only way to make it work is to change the key of the child CreateEditCustomer.vue.
     * https://michaelnthiessen.com/key-changing-technique/
     */
    componentKey: 0,
});
            
const emit = defineEmits(['submitCustomer']);

/**
 * Triggers the process of create/edit customer on Index.vue
 */
const submitCustomer = () => {
    emit('submitCustomer');//send the customer to the parent Index.vue
};

</script>

<style scoped>

</style>

