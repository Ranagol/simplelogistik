<template>
    <el-dialog
        v-model="elDialogVisible"
        title="Create new customer"
    >
        <!-- CREATE CUSTOMER -->
        <CreateEditCustomer></CreateEditCustomer>

        <!-- FOOTER WITH CANCEL AND CONFIRM -->
        <template #footer>
            <span class="dialog-footer">

                <el-button
                    @click="elDialogVisible = false"
                >Cancel</el-button>

                <el-button 
                    type="primary" 
                    @click="elDialogVisible = false"
                >Confirm</el-button>
            </span>
        </template>
    </el-dialog>

    <el-button
        @click="elDialogVisible = true"
    >Create new customer</el-button>

</template>

<script lang="ts">
import { defineComponent } from 'vue';
import CreateEditCustomer from '@/Pages/Customers/CreateEditCustomer.vue';
export default defineComponent({
    components: {
        CreateEditCustomer
    },
    data() {
        return {
            elDialogVisible: true,
        }
    },
    computed: {
    },
    methods: {
    },

});
</script>

<style scoped>

</style>