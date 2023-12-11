<template>

    <el-tabs
        type="border-card"
        stretch
    >
        <!-- CUSTOMER GENERAL DATA -->
        <el-tab-pane
            label="General customer data"
        >
            <DataTab
                v-model="data.customer"
                :errors="props.errors"
                :mode="props.mode"
                @submit="submit"
                @destroy="destroy"
            >
            </DataTab>
        </el-tab-pane>

        <!-- INDIVIDUAL SETTINGS -->
        <el-tab-pane
            label="Individual settings"
        >
            <IndividualTab
                v-model="data.customer"
                :errors="props.errors"
                :mode="props.mode"
                :selectOptions="props.selectOptions"
                @submit="submit"
                @destroy="destroy"
            >
            </IndividualTab>
        </el-tab-pane>

        <!-- COMMENTS -->
        <el-tab-pane
            label="Comments"
        >
            <CommentsTab
                :customer="data.customer"
                :errors="props.errors"
            />
            
        </el-tab-pane>

        <!-- ADDRESSES -->
        <el-tab-pane
            label="Addresses"
        >
            <AddressesTab
                v-model="data.customer"
                :errors="props.errors"
            >
            </AddressesTab>
        </el-tab-pane>

        <!-- CONTACTS -->
        <el-tab-pane
            label="Contacts"
        >
            <ContactsTab
                v-model="data.customer"
                :errors="props.errors"
            >   
            </ContactsTab>
        </el-tab-pane>

        <!-- ORDERS -->
        <el-tab-pane
            label="Orders"
        >
            <OrdersTab
                v-model="data.customer"
                :errors="props.errors"
            >
            </OrdersTab>
        </el-tab-pane>

        <!-- OFFERS -->
        <el-tab-pane
            label="Offers"
        >
            <OffersTab
                v-model="data.customer"
                :errors="props.errors"
            >    
            </OffersTab>    
        </el-tab-pane>

        

    </el-tabs>

</template>

<script setup>
import { reactive, ref, onBeforeMount, watch, computed } from 'vue';
import DataTab from '@/Pages/Customers/CreateEditCustomer/CustomerTabs/DataTab.vue';
import AddressesTab from '@/Pages/Customers/CreateEditCustomer/CustomerTabs/AddressesTab.vue';
import ContactsTab from '@/Pages/Customers/CreateEditCustomer/CustomerTabs/ContactsTab.vue';
import OrdersTab from '@/Pages/Customers/CreateEditCustomer/CustomerTabs/OrdersTab.vue';
import OffersTab from '@/Pages/Customers/CreateEditCustomer/CustomerTabs/OffersTab.vue';
import IndividualTab from '@/Pages/Customers/CreateEditCustomer/CustomerTabs/IndividualTab.vue';
import CommentsTab from '@/Pages/Customers/CreateEditCustomer/CustomerTabs/CommentsTab.vue';
import ButtonSubmitTab from '@/Shared/ButtonSubmitTab.vue';
import _ from 'lodash';

const props = defineProps({

    /**
     * The customer object.
     */
    customer: {
        type: Object,
        required: true
    },

    /**
     * mode is either 'create' or 'edit'. This is decided in the controller. This component will
     * behave differently depending on which mode is it.
     */
    mode: {
        type: String,
        required: true
    },

    /**
     * The errors object that is sent from the backend, and contains the validation errors.
     */
    errors: Object,

    /**
     * These are the possibly selectable options for the el-select in customer create or edit form.
     * The options are fetched from the backend.
     */
    selectOptions: Object,
});


const data = reactive({

    /**
     * The customer object.
     */
    customer: props.customer
});

const emit = defineEmits(['submit', 'update:customer', 'destroy']);

/**
 * This watcher is needed for comment creating. When a comment is created, the backend sends back
 * the updated customer object, and we need to update the customer object in this component. But,
 * only the comments property of the customer object is updated. Which is a nested property update.
 * Vue can't see this change, without this watcher. But, with this watcher, Vue can see the change.
 * Then the customer with the new comments arrives to data. Then it is automatically passed to the
 * child component. Which is what we wanted.
 */
watch(
    () => props.customer, 
    (newValue, oldValue) => {
        data.customer = newValue;
    },
    { deep: true }
);

/**
 * Watch for changes in the customer object. In case of any change, it will immediatelly
 * update the parent component's customer object. We must use here watcher, because of the tabs.
 * In addresses, where there are no tabs, no watchers is used.
 */
watch(
    () => data.customer, 
    (newValue, oldValue) => {
        // console.log('data.customer changed', newValue, oldValue);
        emit('update:customer', newValue);
    },
    { deep: true }
);

const submit = () => {
    emit('submit');
}  

const destroy = () => {
    emit('destroy');
}

</script>