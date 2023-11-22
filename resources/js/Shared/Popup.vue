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
        modelValue: {
            type: Boolean,
            default: false
        },

        errors: Object,
        // elDialogVisible: Boolean,
        mode: String,
        selectedCustomer: Object,
    },
    components: {
        CreateEditCustomer
    },
    data() {
        return {
            // elDialogVisibleData: this.elDialogVisible,
        }
    },
    computed: {
        title() {
            switch (this.mode) {
                case 'create':
                    console.log('Popup computed: In popup.vue, mode is create')
                    // console.log('Popup computed: props elDialogVisible: ', this.elDialogVisible)
                    // console.log('data elDialogVisibleData: ', this.elDialogVisibleData)
                    return 'Create new customer';
                    break;
                case 'show':
                    console.log('Popup computed: In popup.vue, mode is show')
                    // console.log('Popup computed: props elDialogVisible: ', this.elDialogVisible)
                    // console.log('Popup computed: data elDialogVisibleData: ', this.elDialogVisibleData)
                    return 'Show customer';
                    break;
                case 'edit':
                    console.log('Popup computed: In popup.vue, mode is edit')
                    // console.log('Popup computed: props elDialogVisible: ', this.elDialogVisible)
                    // console.log('Popup computed: data elDialogVisibleData: ', this.elDialogVisibleData)
                    return 'Edit customer';
                    break;
            }
        },
    },
    emits: ['closePopup', 'update:modelValue'],
    methods: {
        closePopup(){
            // this.elDialogVisibleData = false;
            // this.$emit('closePopup', false);
            this.$emit('update:modelValue', false);
        }
    },

});
</script>

<style scoped>

</style>