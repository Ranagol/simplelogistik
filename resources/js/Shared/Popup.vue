<template>
    <el-dialog
        v-model="elDialogVisible"
        :title=title
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
        errors: Object,
        elDialogVisible: Boolean,
        mode: String,
        selectedCustomer: Object,
    },
    components: {
        CreateEditCustomer
    },
    data() {
        return {
            elDialogVisibleData: this.props,
        }
    },
    computed: {
        title() {
            switch (this.mode) {
                case 'create':
                    console.log('In popup.vue, mode is create')
                    return 'Create new customer';
                    break;
                case 'show':
                    console.log('In popup.vue, mode is show')
                    return 'Show customer';
                    break;
                case 'edit':
                    console.log('In popup.vue, mode is edit')
                    return 'Edit customer';
                    break;
            }
        },
    },
    emits: ['closePopup'],
    methods: {
        closePopup(){
            // this.elDialogVisibleData = false;
            this.$emit('closePopup', false);
        }
    },

});
</script>

<style scoped>

</style>