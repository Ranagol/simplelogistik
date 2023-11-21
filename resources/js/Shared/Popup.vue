<template>
    <el-dialog
        v-model="elDialogVisible"
        title="Create new customer"
    >
        <!-- CREATE CUSTOMER -->
        <CreateEditCustomer
            :errors="errors"
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
        elDialogVisible: Boolean
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