<template>
    <!-- @open="refreshElDialog" -->
    <el-dialog
        v-model="customerStore.elDialogVisible"
        :title=customerStore.title
        @open="handleDialogOpened"
    >
    <!-- :key="componentKey" -->
    <!-- :resetForm="data.resetForm" -->
    <!-- @onCancelEditResetElDialogDisplay="onCancelEditResetElDialogDisplay" -->
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

let handleDialogOpened = () => {
    data.componentKey += 1;
    data.resetForm = true;  
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
    resetForm: false,
});
            
const emit = defineEmits(['submitCustomer','resetEditedCustomer']);

const submitCustomer = (customer: Customer) => {
    emit('submitCustomer', customer);//send the customer to the parent Index.vue
};

const resetEditedCustomer = () => {
    emit('resetEditedCustomer');
};
    
// /**
//  * This is used to refresh the el-dialog component.
//  * Problem: choose customer to edit, then click cancel, and then choose another customer to edit.
//  * While the app knows the correct customer to edit, the el-dialog component does not display the
//  * correct customer. The only way to make it work is to change the key of the child CreateEditCustomer.vue.
//  */
// const onCancelEditResetElDialogDisplay = () => {
    
// };


// const refreshElDialog = () => {
//     data.componentKey += 1;//very important, forces the el-dialog component to re-render
// };

</script>

<style scoped>

</style>

