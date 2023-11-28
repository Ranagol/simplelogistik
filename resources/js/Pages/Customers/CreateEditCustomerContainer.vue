<template>
    <CreateEditView
        :rules="rules"
        :store:'customerStore'
        :inputFields="data.inputFields"
    />
</template>

<script lang="ts" setup>
import { reactive, ref, watch, onMounted, onActivated, onUpdated, onBeforeMount } from 'vue';
import type { FormInstance, FormRules } from 'element-plus'
import { useCustomerStore } from '@/Stores/customerStore';
import CreateEditView from '@/Shared/CreateEditView.vue';

let customerStore = useCustomerStore();
let data = reactive({
    inputFields: [
        {
            label: 'Company name',
            prop: 'company_name',
            type: 'text',
            showWordLimit: true,
            maxlength: 255,
            clearable: true,
            placeholder: 'Company name',
        },
        {
            label: 'Name',
            prop: 'name',
            type: 'text',
            showWordLimit: true,
            maxlength: 255,
            clearable: true,
            placeholder: 'Name',
        },
        {
            label: 'Email',
            prop: 'email',
            type: 'text',
            showWordLimit: true,
            maxlength: 255,
            clearable: true,
            placeholder: 'Email',
        },
        {
            label: 'Rating',
            prop: 'rating',
            type: 'text',
            showWordLimit: true,
            maxlength: 255,
            clearable: true,
            placeholder: 'Rating',
        },
        {
            label: 'Tax number',
            prop: 'tax_number',
            type: 'text',
            showWordLimit: true,
            maxlength: 255,
            clearable: true,
            placeholder: 'Tax number',
        },
        {
            label: 'Internal CID',
            prop: 'internal_cid',
            type: 'text',
            showWordLimit: true,
            maxlength: 255,
            clearable: true,
            placeholder: 'Internal CID',
        },
        

    ],
});

/**
 * Here we define, what structure should have the customer object.
 */
interface RuleForm {
    company_name: string,
    name: string,
    email: string,
    rating: string,
    tax_number: string,
    internal_cid: string,
}

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
 * The validation rules for the form.
 */
const rules = reactive<FormRules<RuleForm>>({
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