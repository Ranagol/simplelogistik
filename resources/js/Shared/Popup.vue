<template>
    <el-dialog
        v-model="modelValue"
        :title=title
        @closed="closePopup"
    >
        <!-- CREATE CUSTOMER -->
        <CreateEditCustomer
            :errors="errors"
            :selectedCustomer="selectedCustomer"
            :mode="mode"
            @closePopup="closePopup"
        ></CreateEditCustomer>

    </el-dialog>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import CreateEditCustomer from '@/Pages/Customers/CreateEditCustomer.vue';
export default defineComponent({
    props: {
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
        selectedCustomer: Object,
    },
    components: {
        CreateEditCustomer
    },
    computed: {

        /**
         * Title of the popup. Depends on the mode. Only the title is affected by this computed.
         */
        title() {
            switch (this.mode) {
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
        },
    },
    emits: ['closePopup', 'update:modelValue', 'removeSelectedCustomer'],
    methods: {

        /**
         * Close the popup. Triggered by the closed() event of the el-dialog component.
         * Sends a message to the parent Index.vue/elDialogVisible, to which is connected by
         * v-model:modelValue.
         */
        closePopup(){
            this.$emit('update:modelValue', false);
            this.$emit('removeSelectedCustomer');
        }
    },

});
</script>

<style scoped>

</style>

