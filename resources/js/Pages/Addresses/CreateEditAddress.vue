<template>
    <div>
        <el-form
            ref="ruleFormRef"
            :model="address"
            label-position="left"
            :rules="rules"
            label-width="120px"
        >
        <!-- prop="company_name" -->
            <el-form-item
                v-for="inputField in address"
                :key="inputField.prop"
                :label="inputField.label"
            >
                <component
                    :is="inputField.element"
                    v-model="inputField.value"
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
 * The address object that is being sent to the backend.
 * This line is creating a reactive object using Vue's reactive function. The reactive function is 
 * used to create a reactive and mutable object. The object is of type TmsAddress (as defined earlier), 
 * and it's initially set with all properties as empty strings. 
 */
 let address = reactive({
//     //Use this for creating a new address
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
const rules = reactive<FormRules<TmsAddress>>({
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
    // // rating: [
    // //     { required: true, message: 'Rating is required FE', trigger: 'blur' },
    // // ],
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
const emit = defineEmits(['submit']);
const submitForm = async (formEl: FormInstance | undefined) => {
    if (!formEl) return;

    await formEl.validate((valid, fields) => {
        if (valid) {//if validation is OK, then submit the address
            
            const purifiedAddress = purifyAddressData(address);
            addressStore.selectedCustomer = purifiedAddress;
            emit('submit');
            
        } else {//if validation is not OK, then show the errors
            // console.log('FE validation not OK, error submit!', fields)
            // console.log('address:', address)
            // console.log('addressStore.selectedCustomer:', addressStore.selectedCustomer)
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
    addressStore.selectedCustomer = addressStore.customerResetValues;//resetting all address fields
}

/**
 * Update the selectedCustomer object in store. This is needed when the mode is 'show'
 * or 'edit'. Not needed for create mode.
 */
let updateSelectedCustomer = () => {
    addressStore.selectedCustomer = address;
}

/**
 * Before this component is mounted, if we are in edit mode, then we have to set the empty address
 * form to be = to the selectedCustomer, that has to be edited.
 */
onBeforeMount(() => {
    if (addressStore.mode==='edit') {
        address = addressStore.selectedCustomer; 
    }
});

onMounted(() => {
    if (addressStore.mode==='create') {
        address.first_name.value = 'Arni';
        address.last_name.value = 'Schmidt';
        address.street.value = 'Hauptstrasse';
        address.house_number.value = '1';
        address.zip_code.value = '1234';
        address.city.value = 'Wien';
        address.country.value = 'Austria';
        address.state.value = 'Wien';
        address.type_of_address.value = 'Home';
        address.comment.value = 'This is a comment';
        address.customer_id.value = '1';
        address.forwarder_id.value = '1';
    }
});

</script>

<style scoped>

</style>