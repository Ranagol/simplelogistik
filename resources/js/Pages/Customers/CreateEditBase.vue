<template>

    <!-- <Head
        v-if="customerData !== undefined"
        :title="customerData.company_name"
    /> -->

    <Card>
        <!-- <h1
            class="font-semibold text-xl text-gray-800 leading-tight mb-2"
        >{{ customerData.company_name }}</h1> -->

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
import DataTab from '@/Pages/Customers/CustomerTabs/DataTab.vue';
import AddressesTab from '@/Pages/Customers/CustomerTabs/AddressesTab.vue';
import ContactsTab from '@/Pages/Customers/CustomerTabs/ContactsTab.vue';
import OrdersTab from '@/Pages/Customers/CustomerTabs/OrdersTab.vue';
import OffersTab from '@/Pages/Customers/CustomerTabs/OffersTab.vue';
import IndividualTab from '@/Pages/Customers/CustomerTabs/IndividualTab.vue';
import ButtonSubmitTab from '@/Shared/ButtonSubmitTab.vue';
import Card from '@/Shared/Card.vue';
import { router } from '@inertiajs/vue3'


const props = defineProps({

    /**
     * The customer object.
     */
    record: {
        type: Object,
        required: true
    }
});


const data = reactive({
    customerData: props.record
});

const submit = () => {
    console.log('submit');
    editCustomer();

}

const editCustomer = () => {
    router.put(
        `/customers/${data.customerData.id}`, 
        data.customerData,
        {
            onSuccess: () => {
                ElMessage({
                    message: 'Customer edited successfully',
                    type: 'success',
                });
                router.reload({ only: ['record'] })
            },
            onError: (errors) => {
                ElMessage.error('Oops, something went wrong while editing a customer.')
                ElMessage(errors);
            }
        }
    )
};

const createCustomer = () => {
    router.post(
        '/customers', 
        customerStore.selectedCustomer, 
        {
            onSuccess: () => {
                ElMessage({
                    message: 'Customer created successfully',
                    type: 'success',
                });
                // get customers again, so that the new customer is displayed
                router.reload({ only: ['dataFromController'] })
                customerStore.elDialogVisible = false;
            },
            onError: (errors) => {
                ElMessage.error('Oops, something went wrong while creating a new customer.')
                ElMessage(errors);
            }
        }
    )
};




</script>

<style scoped>

</style>