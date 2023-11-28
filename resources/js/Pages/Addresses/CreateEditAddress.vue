<template>
    <div>
        <el-form
            ref="ruleFormRef"
            :model="address"
            label-position="left"
            :rules="rules"
            label-width="120px"
        >
            <!-- Here we loop out our input field. Now this looping has two sources:
            1. address: this is for v-model and frontend validation.
            2. addressFields: this is hardcoded data, for actually looping out the input fields. -->
            <el-form-item
                v-for="(inputField, index) in addressFields"
                :key="inputField.id"
                :label="inputField.label"
                :prop="inputField.prop"
            >
                <component
                    :is="inputField.element"
                    v-model="address[index]"
                    :placeholder="inputField.placeholder"
                    type="text"
                    :show-word-limit="inputField.showWordLimit"
                    :maxlength="inputField.maxlength"
                    clearable
                    @input="updateSelectedCustomer()"
                    @clear="updateSelectedCustomer()"
                    @change="updateSelectedCustomer()"
                />

                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="addressStore.errors[inputField.prop]"
                    v-text="addressStore.errors[inputField.prop]"
                    class="text-red-500 text-xs mt-1"
                ></div>
            </el-form-item>


            <div
                class="flex flex-row"
                v-if="addressStore.mode==='create' || addressStore.mode==='edit' "
            >
                <!-- SUBMIT BUTTON -->
                <el-form-item class="pr-5">
                    <el-button
                        type="primary"
                        @click="submitForm(ruleFormRef)"
                    >Submit</el-button>
                </el-form-item>
                
                <!-- CANCEL BUTTON -->
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
import { useAddressStore } from '@/Stores/addressStore';
import { TmsAddress } from '@/types/TmsAddress';

let addressStore = useAddressStore();

/**
 * This contains the whole el-form. Needed for the validation.
 */
const ruleFormRef = ref<FormInstance>();
/**
 * Here we loop out our input field. Now this looping has two sources:
    1. address: this is for v-model and frontend validation.
    2. addressFields: this is hardcoded data, for actually looping out the input fields.
 */
let address = reactive<RuleForm>({
    first_name: '',
    last_name: '',
    street: '',
    house_number: '',
    zip_code: '',
    city: '',
    country: '',
    state: '',
    type_of_address: '',
    comment: '',
    customer_id: '',
    forwarder_id: '',
});

/**
 * The address object that is being sent to the backend.
 * This line is creating a reactive object using Vue's reactive function. The reactive function is 
 * used to create a reactive and mutable object. The object is of type TmsAddress (as defined earlier), 
 * and it's initially set with all properties as empty strings. 
 */
let addressFields = reactive({
    first_name: {
        prop: 'first_name',
        value: '',
        element: 'el-input',
        label: 'First name',
        type: 'text',
        placeholder: 'First name',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    last_name: {
        prop: 'last_name',
        value: '',
        element: 'el-input',
        label: 'Last name',
        type: 'text',
        placeholder: 'Last name',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    street: {
        prop: 'street',
        value: '',
        element: 'el-input',
        label: 'Street',
        type: 'text',
        placeholder: 'Street',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    house_number: {
        prop: 'house_number',
        value: '',
        element: 'el-input',
        label: 'House number',
        type: 'text',
        placeholder: 'House number',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    zip_code: {
        prop: 'zip_code',
        value: '',
        element: 'el-input',
        label: 'Zip code',
        type: 'text',
        placeholder: 'Zip code',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    city: {
        prop: 'city',
        value: '',
        element: 'el-input',
        label: 'City',
        type: 'text',
        placeholder: 'City',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    country: {
        prop: 'country',
        value: '',
        element: 'el-input',
        label: 'Country',
        type: 'text',
        placeholder: 'Country',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    state: {
        prop: 'state',
        value: '',
        element: 'el-input',
        label: 'State',
        type: 'text',
        placeholder: 'State',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    type_of_address: {
        prop: 'type_of_address',
        value: '',
        element: 'el-input',
        label: 'Type of address',
        type: 'text',
        placeholder: 'Type of address',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    comment: {
        prop: 'comment',
        value: '',
        element: 'el-input',
        label: 'Comment',
        type: 'text',
        placeholder: 'Comment',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    customer_id: {
        prop: 'customer_id',
        value: '',
        element: 'el-input',
        label: 'Customer ID',
        type: 'text',
        placeholder: 'Customer ID',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    forwarder_id: {
        prop: 'forwarder_id',
        value: '',
        element: 'el-input',
        label: 'Forwarder ID',
        type: 'text',
        placeholder: 'Forwarder ID',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    }
});

/**
 * The validation rules for the form.
 */
const rules = reactive<FormRules<RuleForm>>({
    first_name: [{ required: true, message: 'Please input first name FE', trigger: 'blur' }],
    last_name: [{ required: true, message: 'Please input last name FE', trigger: 'blur' }],
    street: [{ required: true, message: 'Please input street FE', trigger: 'blur' }],
    house_number: [{ required: true, message: 'Please input house number FE', trigger: 'blur' }],
    zip_code: [{ required: true, message: 'Please input zip code FE', trigger: 'blur' }],
    city: [{ required: true, message: 'Please input city FE', trigger: 'blur' }],
    country: [{ required: true, message: 'Please input country FE', trigger: 'blur' }],
    state: [{ required: true, message: 'Please input state FE', trigger: 'blur' }],
    type_of_address: [{ required: true, message: 'Please input type of address FE', trigger: 'blur' }],
    comment: [{ required: true, message: 'Please input comment FE', trigger: 'blur' }],
    customer_id: [{ required: true, message: 'Please input customer id FE', trigger: 'blur' }],
    forwarder_id: [{ required: true, message: 'Please input forwarder id FE', trigger: 'blur' }],
});

/**
 * Does the frontend validation, and if it is OK, then calls the submit() function.
 */
const emit = defineEmits(['submit']);
const submitForm = async (formEl: FormInstance | undefined) => {
    // console.log('validation for triggered');
    if (!formEl) return;

    await formEl.validate((valid, fields) => {
        if (valid) {//if validation is OK, then submit the address
            // console.log('FE validation OK, submit! This is the address', address)
            // const purifiedAddress = purifyAddressData(address);
            addressStore.selectedAddress = address;
            // console.log('addressStore.selectedAddress:', addressStore.selectedAddress)
            emit('submit');
            
        } else {//if validation is not OK, then show the errors
            // console.log('FE validation not OK, error submit!', fields)
            // console.log('address:', address)
            // console.log('addressStore.selectedAddress:', addressStore.selectedAddress)
        }
    })
}

/**
 * Removes input field related data, that was needed for loopin out the input fields, but it is not
 * needed when we send address data to the backend, for create or edit.
 */
const purifyAddressData = (address: object) => {
    let purifiedAddress = {};
    for (let [key, value] of Object.entries(address)) {
        purifiedAddress[key] = value.value;
    }
    return purifiedAddress;
}

/**
 * Close the popup, and resets the address values in this component to empty.
 */
let cancel = () => {
    addressStore.elDialogVisible = false;
    addressStore.selectedAddress = addressStore.customerResetValues;//resetting all address fields
}

/**
 * Update the selectedAddress object in store. This is needed when the mode is 'show'
 * or 'edit'. Not needed for create mode.
 */
let updateSelectedCustomer = () => {
    addressStore.selectedAddress = address;
}

/**
 * Before this component is mounted, if we are in edit mode, then we have to set the empty address
 * form to be = to the selectedAddress, that has to be edited.
 */
onBeforeMount(() => {
    if (addressStore.mode==='edit') {
        address = addressStore.selectedAddress; 
    }
});

/**
 * Creates dummy addresses. This is only for testing purposes. 
 */
onMounted(() => {
    if (addressStore.mode==='create') {
        address.first_name = 'Arni';
        address.last_name = 'Schmidt';
        address.street = 'Hauptstrasse';
        address.house_number = '1';
        address.zip_code = '1234';
        address.city = 'Wien';
        address.country = 'Austria';
        address.state = 'Wien';
        address.type_of_address = 'Home';
        address.comment = 'This is a comment';
        address.customer_id = '1';
        address.forwarder_id = '1';
    }
});

</script>

<style scoped>

</style>