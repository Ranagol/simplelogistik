<template>
    <div>
        <el-form
            ref="ruleFormRef"
            :model="customer"
            label-position="left"
            :rules="rules"
            label-width="150px"
        >
            <el-form-item
                label="Company name"
                prop="company_name"
                width="100px"
            >
                <el-input
                    v-model="customer.company_name"
                    placeholder="Company name"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    :disabled="customerStore.mode==='show'"
                    @input="updateSelectedCustomer()"
                    @clear="updateSelectedCustomer()"
                    @change="updateSelectedCustomer()"
                />

                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="customerStore.errors.company_name"
                    v-text="customerStore.errors.company_name"
                    class="text-red-500 text-xs mt-1"
                ></div>
            </el-form-item>

            <el-form-item
                label="Name"
                prop="name"
            >
                <el-input
                    v-model="customer.name"
                    placeholder="Name"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    :disabled="customerStore.mode==='show'"
                    @input="updateSelectedCustomer()"
                    @clear="updateSelectedCustomer()"
                    @change="updateSelectedCustomer()"
                />

                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="customerStore.errors.name"
                    v-text="customerStore.errors.name"
                    class="text-red-500 text-xs mt-1"
                ></div>
            </el-form-item>

            <el-form-item
                label="Email"
                prop="email"
            >
                <el-input
                    v-model="customer.email"
                    placeholder="Email"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    :disabled="customerStore.mode==='show'"
                    @input="updateSelectedCustomer()"
                    @clear="updateSelectedCustomer()"
                    @change="updateSelectedCustomer()"
                />

                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="customerStore.errors.email"
                    v-text="customerStore.errors.email"
                    class="text-red-500 text-xs mt-1"
                ></div>
            </el-form-item>

            <el-form-item
                label="Rating"
                prop="rating"
            >
                <el-input
                    v-model="customer.rating"
                    placeholder="Rating"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    :disabled="customerStore.mode==='show'"
                    @input="updateSelectedCustomer()"
                    @clear="updateSelectedCustomer()"
                    @change="updateSelectedCustomer()"
                />
                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="customerStore.errors.rating"
                    v-text="customerStore.errors.rating"
                    class="text-red-500 text-xs mt-1"
                ></div>
            </el-form-item>

            <el-form-item
                label="Tax number"
                prop="tax_number"
            >
                <el-input
                    v-model="customer.tax_number"
                    placeholder="Tax number"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    :disabled="customerStore.mode==='show'"
                    @input="updateSelectedCustomer()"
                    @clear="updateSelectedCustomer()"
                    @change="updateSelectedCustomer()"
                />
                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="customerStore.errors.tax_number"
                    v-text="customerStore.errors.tax_number"
                    class="text-red-500 text-xs mt-1"
                ></div>
            </el-form-item>

            <el-form-item
                label="Internal CID"
                prop="internal_cid"
            >
                <el-input
                    v-model="customer.internal_cid"
                    placeholder="Internal CID"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    :disabled="customerStore.mode==='show'"
                    @input="updateSelectedCustomer()"
                    @clear="updateSelectedCustomer()"
                    @change="updateSelectedCustomer()"
                />
                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="customerStore.errors.internal_cid"
                    v-text="customerStore.errors.internal_cid"
                    class="text-red-500 text-xs mt-1"
                ></div>
            </el-form-item>

            <!-- BUTTONS will be displayed in create and edit mode, and will not be displayed
            in show mode.-->
            <div
                class="flex flex-row"
                v-if="customerStore.mode==='create' || customerStore.mode==='edit' "
            >
                <el-form-item class="pr-5">
                    <el-button
                        type="primary"
                        @click="submitForm(ruleFormRef)"
                    >Submit</el-button>
                </el-form-item>
    
                <el-form-item class="pr-5">
                    <el-button
                        type="danger"
                        @click="cancel"
                    >Cancel</el-button>
                </el-form-item>

            </div>
        </el-form>
    </div>
</template>

<script setup>
import { reactive, ref, onBeforeMount } from 'vue';
import { useCustomerStore } from '@/Stores/customerStore';

let customerStore = useCustomerStore();

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
    // rating: [
    //     { required: true, message: 'Rating is required FE', trigger: 'blur' },
    // ],
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

/**
 * Before this component is mounted, if we are in edit mode, then we have to set the empty customer
 * form to be = to the selectedCustomer, that has to be edited.
 */
onBeforeMount(() => {
    if (customerStore.mode==='edit') {
        customer = customerStore.selectedCustomer; 
    }
});

</script>

<style scoped>

</style>