<template>
    <Card>
        <el-tabs type="border-card">
            <el-tab-pane label="General customer data">General customer data</el-tab-pane>
            <el-tab-pane label="Addresses">Addresses</el-tab-pane>
            <el-tab-pane label="Contacts">Contacts</el-tab-pane>
            <el-tab-pane label="Orders">Orders</el-tab-pane>
            <el-tab-pane label="Offers">Offers</el-tab-pane>
            <el-tab-pane label="Individual settings">Individual settings</el-tab-pane>
        </el-tabs>
    </Card>
</template>

<script setup>
import { reactive, ref, onBeforeMount } from 'vue';
import { useCustomerStore } from '@/Stores/customerStore';


const props = defineProps({
    customer: {
        type: Object,
        required: true
    }
});




</script>

<style scoped>

</style>