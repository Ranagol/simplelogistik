<template>
    <el-dialog
        v-model="data.elDialogVisible"
        :title=title
        @closed="closePopup"
    >
        <!-- CREATE CUSTOMER -->
        <CreateEditCustomer
            :errors="props.errors"
            v-model:selectedCustomer="data.selectedCustomer"
            v-model:mode="data.mode"
            @closePopup="closePopup"
            @submitCustomer="submitCustomer"
            :key="componentKey"
        ></CreateEditCustomer>

    </el-dialog>
</template>

<script lang="ts" setup>
import CreateEditCustomer from '@/Pages/Customers/CreateEditCustomer.vue';
import { reactive, computed, watch, onMounted, nextTick, onActivated, ref } from 'vue';
import { router} from '@inertiajs/vue3';//for sending requests

let props = defineProps(
    {

        /**
         * The v-model of the el-dialog component. This is the only way to close the popup.
         */
        elDialogVisible: Boolean,

        /**
         * The errors object from the parent Index.vue. This is passed to the child CreateEditCustomer.vue.
         */
        errors: Object,

        /**
         * The mode of the popup. This is passed to the child CreateEditCustomer.vue. It could be 
         * 'create', 'show' or 'edit'.
         */
        mode: String,

        /**
         * The selected customer object from the parent Index.vue. This is passed to the child 
         * CreateEditCustomer.vue. Needed when the mode is 'show' or 'edit'. Not needed for create 
         * mode.
         */
        selectedCustomer: Object,

        /**
         * The title of the popup. This is passed to the child CreateEditCustomer.vue. It could be 
         * 'create', 'show' or 'edit'.
         */
        title: String
    }
);

//DATA
let data = reactive(
    {
        mode: props.mode,
        selectedCustomer: props.selectedCustomer,
        elDialogVisible: props.elDialogVisible,
        customerResetValues: {
            company_name: '',
            name: '',
            email: '',
            rating: '',
            tax_number: '',
            internal_cid: '',
        },
    }
);
        
            
const emit = defineEmits(
    [
        'closePopup', 
        'update:elDialogVisible', 
        'update:mode',
        'update:selectedCustomer',
        'submitCustomer'
    ]
);

/**
 * Close the popup. Triggered by the closed() event of the el-dialog component.
 * Sends a message to the parent Index.vue/elDialogVisible, to which is connected by
 * v-model:modelValue.
 */
const closePopup = () => {
    emit('update:elDialogVisible', false);
    emit('update:mode', data.mode);
    emit('update:selectedCustomer', data.customerResetValues);
    data.selectedCustomer = data.customerResetValues;
};

const submitCustomer = (customer: Customer) => {
    emit('submitCustomer', customer);
};

watch(
    () => props.elDialogVisible,
    (newValue, oldValue) => {
        data.elDialogVisible = newValue;
    },
    { immediate: true }
);

watch(
    () => props.mode,
    (newValue, oldValue) => {
        data.mode = newValue;
    },
    { immediate: true }
);



const componentKey = ref(0);

watch(
    () => props.selectedCustomer,
    (newValue, oldValue) => {
        console.log('Popup: watcher selectedCustomer, new value old value: ', newValue, oldValue);
        data.selectedCustomer = newValue;
        componentKey.value += 1;
    },
    { immediate: true }
);



</script>

<style scoped>

</style>

