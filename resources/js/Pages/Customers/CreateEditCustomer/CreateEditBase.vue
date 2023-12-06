<template>

    <!-- //TODO this has to be corrected. -->
    <Head
        :title="props.mode"
    />

    <Card>
        <div class="flex flex-row mb-3">
            <h1
                class="font-semibold text-xl text-gray-800 leading-tight mr-6"
            >Edit</h1>

            <span
                v-if="data.customerData.company_name"
                class="font-semibold text-xl text-gray-800 leading-tight mr-6"
            >{{data.customerData.company_name }}</span>

            <span
                v-if="data.customerData.internal_cid"
                class="font-semibold text-xl text-gray-800 leading-tight mr-6"
            >Customer number: {{data.customerData.internal_cid }}</span>
        </div>
        

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
                    :errors="errorsComputed"
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
                    :errors="errorsComputed"
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
                    :errors="errorsComputed"
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
                    :errors="errorsComputed"
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
                    :errors="errorsComputed"
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
                    :errors="errorsComputed"
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
import { reactive, ref, onBeforeMount, watch, computed } from 'vue';
import DataTab from '@/Pages/Customers/CreateEditCustomer/CustomerTabs/DataTab.vue';
import AddressesTab from '@/Pages/Customers/CreateEditCustomer/CustomerTabs/AddressesTab.vue';
import ContactsTab from '@/Pages/Customers/CreateEditCustomer/CustomerTabs/ContactsTab.vue';
import OrdersTab from '@/Pages/Customers/CreateEditCustomer/CustomerTabs/OrdersTab.vue';
import OffersTab from '@/Pages/Customers/CreateEditCustomer/CustomerTabs/OffersTab.vue';
import IndividualTab from '@/Pages/Customers/CreateEditCustomer/CustomerTabs/IndividualTab.vue';
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
});

/**
 * This watcher simply helps to validation errors from props.errors to go to the child components.
 * For some reason this is not reactive enough without the computed.
 */
let errorsComputed = computed(() => {
    return props.errors;
});



const data = reactive({

    /**
     * The customer object.
     */
    customerData: props.record
});

const submit = () => {
    console.log('submit');
    if (props.mode === 'edit') {
        edit();
    } else {
        create();
    }

}

const edit = () => {
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

// const create = () => {
//     router.post(
//         '/customers', 
//         customerStore.selectedCustomer, 
//         {
//             onSuccess: () => {
//                 ElMessage({
//                     message: 'Customer created successfully',
//                     type: 'success',
//                 });
//                 // get customers again, so that the new customer is displayed
//                 router.reload({ only: ['dataFromController'] })
//                 customerStore.elDialogVisible = false;
//             },
//             onError: (errors) => {
//                 ElMessage.error('Oops, something went wrong while creating a new customer.')
//                 ElMessage(errors);
//             }
//         }
//     )
// };


/**
 * This contains the whole el-form. Needed for the validation.
 */
 const ruleFormRef = ref()

/**
 * The customer object that is being sent to the backend.
 * This line is creating a reactive object using Vue's reactive function. The reactive function is 
 * used to create a reactive and mutable object. The object is of type RuleForm (as defined earlier), 
 * and it's initially set with all properties as empty strings. 
 */
 let customer = reactive({
    //Use this for creating a new customer
    // company_name: '',
    // name: '',
    // email: '',
    // rating: '',
    // tax_number: '',
    // internal_cid: '',

    //Use this to stamp customers during development
    company_name: 'Dummy from Create',
    name: 'sdfv',
    email: 'bla@gmail.com',
    rating: '5',
    tax_number: '5555',
    internal_cid: '66666',
})

/**
 * The validation rules for the form.
 */
const rules = reactive({
    company_name: [
        { required: true, message: 'Company name is required FE', trigger: 'blur' },
        { min: 3, max: 100, message: 'Length should be 3 to 100', trigger: 'blur' },
    ],
    name: [
            { required: true, message: 'Name is required FE', trigger: 'blur' },
        ],
    email: [
        { required: true, message: 'Email is required FE', trigger: 'blur' },
    ],
    rating: [
        { required: true, message: 'Rating is required FE', trigger: 'blur' },
    ],
    tax_number: [
        { required: true, message: 'Tax number is required FE', trigger: 'blur' },
    ],
    internal_cid: [
        { required: true, message: 'Internal CID is required FE', trigger: 'blur' },
    ],
})

/**
 * Does the frontend validation, and if it is OK, then calls the submit() function.
 */
const emit = defineEmits(['submit']);
const submitForm = async (formEl) => {
    if (!formEl) return;

    await formEl.validate((valid, fields) => {
        if (valid) {//if validation is OK, then submit the customer
            
            customerStore.selectedCustomer = customer;
            emit('submit');
            
        } else {//if validation is not OK, then show the errors
            // console.log('FE validation not OK, error submit!', fields)
            // console.log('customer:', customer)
            // console.log('customerStore.selectedCustomer:', customerStore.selectedCustomer)
        }
    })
}

/**
 * Close the popup, and resets the customer values in this component to empty.
 */
let cancel = () => {
    customerStore.elDialogVisible = false;
    customerStore.selectedCustomer = customerStore.customerResetValues;//resetting all customer fields
}

/**
 * Update the selectedCustomer object in store. This is needed when the mode is 'show'
 * or 'edit'. Not needed for create mode.
 */
let updateSelectedCustomer = () => {
    customerStore.selectedCustomer = customer;
}




</script>

<style scoped>

</style>