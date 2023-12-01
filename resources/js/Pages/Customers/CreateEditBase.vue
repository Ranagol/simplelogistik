<template>

    <Head :title="customer.company_name"/>

    <Card>
        <h1
            class="font-semibold text-xl text-gray-800 leading-tight mb-2"
        >{{ customer.company_name }}</h1>

        <el-tabs
            type="border-card"
            stretch
        >
            <!-- CUSTOMER GENERAL DATA -->
            <el-tab-pane
                label="General customer data"
            >
                <DataTab
                    v-model="data.customerData"
                >
                    <template #buttonSubmitTab>
                        <ButtonSubmitTab
                            @submit="submit"
                        />
                    </template>
                </DataTab>
            </el-tab-pane>

            <!-- ADDRESSES -->
            <el-tab-pane
                label="Addresses"
            >
                <AddressesTab
                    v-model="data.customerData"
                >
                    <template #buttonSubmitTab>
                        <ButtonSubmitTab
                            @submit="submit"
                        />
                    </template>
                </AddressesTab>
            </el-tab-pane>

            <!-- CONTACTS -->
            <el-tab-pane
                label="Contacts"
            >
                <ContactsTab
                    v-model="data.customerData"
                >   
                    <template #buttonSubmitTab>
                        <ButtonSubmitTab
                            @submit="submit"
                        />
                    </template>
                </ContactsTab>
            </el-tab-pane>

            <!-- ORDERS -->
            <el-tab-pane
                label="Orders"
            >
                <OrdersTab
                    v-model="data.customerData"
                >
                    <template #buttonSubmitTab>
                        <ButtonSubmitTab
                            @submit="submit"
                        />
                    </template>
                </OrdersTab>
            </el-tab-pane>

            <!-- OFFERS -->
            <el-tab-pane
                label="Offers"
            >
                <OffersTab
                    v-model="data.customerData"
                >
                    <template #buttonSubmitTab>
                        <ButtonSubmitTab
                            @submit="submit"
                        />
                    </template>    
                </OffersTab>    
            </el-tab-pane>

            <!-- INDIVIDUAL SETTINGS -->
            <el-tab-pane
                label="Individual settings"
            >
                <IndividualTab
                    v-model="data.customerData"
                >
                    <template #buttonSubmitTab>
                        <ButtonSubmitTab
                            @submit="submit"
                        />
                    </template>
                </IndividualTab>
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
import ButtonSubmitTab from '@/Shared/ButtonSubmitTab.vue';
import Card from '@/Shared/Card.vue';

const props = defineProps({

    /**
     * The customer object.
     */
    customer: {
        type: Object,
        required: true
    }
});


const data = reactive({
    customerData: props.customer
});

const submit = () => {
    console.log('submit');
}




</script>

<style scoped>

</style>