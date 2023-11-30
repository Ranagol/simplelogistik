<template>

    <Head :title="customer.company_name"/>

    <Card>
        <h1
            class="font-semibold text-xl text-gray-800 leading-tight mb-2"
        >Customer: {{ customer.company_name }}</h1>

        <el-tabs
            type="border-card"
            stretch
        >
            <el-tab-pane
                label="General customer data"
            >
                <DataTab
                    v-model="data.customerData"
                />
            </el-tab-pane>

            <el-tab-pane
                label="Addresses"
            >
                <AddressesTab
                    v-model="data.customerData"
                />
            </el-tab-pane>

            <el-tab-pane
                label="Contacts"
            >
                <ContactsTab
                    v-model="data.customerData"
                />
            </el-tab-pane>

            <el-tab-pane
                label="Orders"
            >
                <OrdersTab
                    v-model="data.customerData"
                />
            </el-tab-pane>

            <el-tab-pane
                label="Offers"
            >
                <OffersTab
                    v-model="data.customerData"
                />
            </el-tab-pane>

            <el-tab-pane
                label="Individual settings"
            >
                <IndividualTab
                    v-model="data.customerData"
                />
            </el-tab-pane>
        </el-tabs>
    </Card>
    
</template>

<script setup>
import { reactive, ref, onBeforeMount, watch } from 'vue';
import { useCustomerStore } from '@/Stores/customerStore';
import DataTab from '@/Pages/Customers/CustomerTabs/DataTab.vue';
import AddressesTab from '@/Pages/Customers/CustomerTabs/AddressesTab.vue';
import ContactsTab from '@/Pages/Customers/CustomerTabs/ContactsTab.vue';
import OrdersTab from '@/Pages/Customers/CustomerTabs/OrdersTab.vue';
import OffersTab from '@/Pages/Customers/CustomerTabs/OffersTab.vue';
import IndividualTab from '@/Pages/Customers/CustomerTabs/IndividualTab.vue';



const props = defineProps({

    /**
     * The customer object.
     */
    customer: {
        type: Object,
        required: true
    }
});

watch(
    () => props.customer, 
    (newVal) => {
        data.customerData = newVal;
    }
);

const data = reactive({
    customerData: props.customer
});




</script>

<style scoped>

</style>