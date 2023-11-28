<template>
    <div>

        <!-- :model="customer" is an empty object here in this component -->
        <el-form
            ref="ruleFormRef"
            :model="customer"
            label-position="top"
            :rules="props.rules"
            
        >
            <el-form-item
                v-for="inputField in props.inputFields"
                :key="inputField.prop"
                :label="inputField.label"
                :prop="inputField.prop"
            >
                <!-- INPUT FIELD -->
                <el-input
                    v-model="customer.company_name"
                    placeholder="Company name"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
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

            <!-- BUTTONS will be displayed in create and edit mode, and will not be displayed
            in show mode.-->
            <div
                class="flex flex-row"
                v-if="customerStore.mode==='create' || customerStore.mode==='edit' "
            >
                <!-- SUBMIT -->
                <el-form-item class="pr-5">
                    <el-button
                        type="primary"
                        @click="submitForm(ruleFormRef)"
                    >Submit</el-button>
                </el-form-item>
    
                <!-- CANCEL -->
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

<script lang="ts" setup>
import { reactive, ref, watch, onMounted, onActivated, onUpdated, onBeforeMount } from 'vue';
import type { FormInstance, FormRules } from 'element-plus'
import { useCustomerStore } from '@/Stores/customerStore';

let customerStore = useCustomerStore();

const props = defineProps({
    rules: Object,
    store: Object,
    inputFields: Array,
});



/**
 * This contains the whole el-form. Needed for the validation.
 */
const ruleFormRef = ref<FormInstance>()

/**
 * The customer object that is being sent to the backend.
 * This line is creating a reactive object using Vue's reactive function. The reactive function is 
 * used to create a reactive and mutable object. The object is of type RuleForm (as defined earlier), 
 * and it's initially set with all properties as empty strings. 
 */
 let customer = reactive<RuleForm>({
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
 * Does the frontend validation, and if it is OK, then calls the submit() function.
 */
const emit = defineEmits(['submit']);
const submitForm = async (formEl: FormInstance | undefined) => {
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