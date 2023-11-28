<template>
    <el-dialog
        v-model="props.store.elDialogVisible"
        :title=props.store.title
        @open="handleDialogOpened"
    >
        <!-- :key="data.componentKey" makes component refreshing -->
        <CreateEditCustomerContainer
            @submit="submit"
            :key="data.componentKey"
        ></CreateEditCustomerContainer>

    </el-dialog>
</template>

<script lang="ts" setup>
import CreateEditCustomerContainer from '@/Pages/Customers/CreateEditCustomerContainer.vue';
import { reactive, watch, ref } from 'vue';

const props = defineProps({
    store: Object,
});
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
            
const emit = defineEmits(['submit']);

/**
 * Triggers the process of create/edit customer on Index.vue
 */
const submit = () => {
    emit('submit');//send the customer to the parent Index.vue
};

</script>

<style scoped>

</style>

