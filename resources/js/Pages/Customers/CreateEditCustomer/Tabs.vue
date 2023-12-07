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
                :selectOptions="props.selectOptions"
            >
            </IndividualTab>
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
        <!-- <el-tab-pane
            label="Contacts"
        >
            <ContactsTab
                v-model="data.customer"
                :errors="props.errors"
            >   
            </ContactsTab>
        </el-tab-pane> -->

        <!-- ORDERS -->
        <!-- <el-tab-pane
            label="Orders"
        >
            <OrdersTab
                v-model="data.customer"
                :errors="props.errors"
            >
            </OrdersTab>
        </el-tab-pane> -->

        <!-- OFFERS -->
        <!-- <el-tab-pane
            label="Offers"
        >
            <OffersTab
                v-model="data.customer"
                :errors="props.errors"
            >    
            </OffersTab>    
        </el-tab-pane> -->

        

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
 * Watch for changes in the customer object. In case of any change, it will immediatelly
 * update the parent component's customer object. We must use here watcher, because of the tabs.
 * In addresses, where there are no tabs, no watchers is used.
 */
watch(
    () => data.customer, 
    (newValue, oldValue) => {
        console.log('data.customer changed', newValue, oldValue);
        emit('update:customer', newValue);
    },
    { deep: true }
);

const submit = () => {
    emit('submit');
    console.log('submit() from Tabs.vue');
}  

const destroy = () => {
    console.log('destroy');
    emit('destroy');
}












/**
 * The validation rules for the form.
 */
 const rules = reactive({
    // company_name: [
    //     { required: true, message: 'Company name is required FE', trigger: 'blur' },
    //     { min: 3, max: 100, message: 'Length should be 3 to 100', trigger: 'blur' },
    // ],
    // name: [
    //         { required: true, message: 'Name is required FE', trigger: 'blur' },
    //     ],
    // email: [
    //     { required: true, message: 'Email is required FE', trigger: 'blur' },
    // ],
    // rating: [
    //     { required: true, message: 'Rating is required FE', trigger: 'blur' },
    // ],
    // tax_number: [
    //     { required: true, message: 'Tax number is required FE', trigger: 'blur' },
    // ],
    // internal_cid: [
    //     { required: true, message: 'Internal CID is required FE', trigger: 'blur' },
    // ],
})

/**
 * Does the frontend validation, and if it is OK, then calls the submit() function.
 */

 

// const submitForm = async (formEl) => {
//     if (!formEl) return;

//     await formEl.validate((valid, fields) => {
//         if (valid) {//if validation is OK, then submit the customer
            
//             emit('submit');
            
//         } else {//if validation is not OK, then show the errors
//             // console.log('FE validation not OK, error submit!', fields)
//             // console.log('customer:', customer)
//             // console.log('customerStore.selectedCustomer:', customerStore.selectedCustomer)
//         }
//     })
// }


</script>