<template>
    <el-dialog
        v-model="elDialogVisible"
        title="Create new customer"
    >
        <!-- CREATE CUSTOMER -->
        <CreateEditCustomer
            @closePopup="elDialogVisible = false"
        ></CreateEditCustomer>
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
            elDialogVisible: false,
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