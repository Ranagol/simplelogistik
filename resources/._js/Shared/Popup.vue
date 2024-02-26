<template>
    <el-dialog
        v-model="props.store.elDialogVisible"
        :title=props.store.title
        @open="handleDialogOpened"
    >
        <!-- SLOT FOR INSERTING CreateEdit... component -->
        <slot
            :key="data.componentKey"
        ></slot>
        
    </el-dialog>
</template>

<script lang="ts" setup>
import { reactive, watch, ref } from 'vue';

const props = defineProps({

    /**
     * Parent Index.vue sends the store object, that contains all necesary data.
     */
    store: Object,
});
/**
 * This is used to refresh the el-dialog component. Absolutely necesary.
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
            

</script>

<style scoped>

</style>

