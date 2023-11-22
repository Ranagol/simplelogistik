<template>
    <el-dialog
        v-model="modelValue"
        :title=title
        @closed="closePopup"
    >
        <!-- CREATE CUSTOMER -->
        <CreateEditCustomer
            :errors="props.errors"
            :selectedCustomer="props.selectedCustomer"
            :mode="mode"
            @closePopup="closePopup"
            @submitCustomer="submitCustomer"
        ></CreateEditCustomer>

    </el-dialog>
</template>

<script lang="ts" setup>
import CreateEditCustomer from '@/Pages/Customers/CreateEditCustomer.vue';
import { reactive, computed, watch, onMounted, nextTick } from 'vue';
import { router} from '@inertiajs/vue3';//for sending requests

let props = defineProps(
    {

        /**
         * The v-model of the el-dialog component. This is the only way to close the popup.
         */
        modelValue: {
            type: Boolean,
            default: false
        },

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
        selectedCustomer: Object
    }
);


/**
 * Title of the popup. Depends on the mode. Only the title is affected by this computed.
 */
let title = computed(() => {
    switch (props.mode) {
        case 'create':
            // console.log('Popup computed: In popup.vue, mode is create')
            return 'Create new customer';
            break;
        case 'show':
            // console.log('Popup computed: In popup.vue, mode is show')
            return 'Show customer';
            break;
        case 'edit':
            // console.log('Popup computed: In popup.vue, mode is edit')
            return 'Edit customer';
            break;
    }
});
        
            
const emit = defineEmits(['closePopup', 'update:modelValue', 'removeSelectedCustomer', 'submitCustomer']);

/**
 * Close the popup. Triggered by the closed() event of the el-dialog component.
 * Sends a message to the parent Index.vue/elDialogVisible, to which is connected by
 * v-model:modelValue.
 */
const closePopup = () => {
    emit('update:modelValue', false);
    emit('removeSelectedCustomer');
};

const submitCustomer = (customer: Customer) => {
    emit('submitCustomer', customer);
};

</script>

<style scoped>

</style>

