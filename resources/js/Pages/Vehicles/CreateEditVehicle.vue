<template>
    <div>
        <el-form
            ref="ruleFormRef"
            :model="vehicle"
            label-position="left"
            :rules="rules"
            label-width="120px"
        >
            <!-- Here we loop out our input field. Now this looping has two sources:
            1. vehicle: this is for v-model and frontend validation.
            2. vehicleFields: this is hardcoded data, for actually looping out the input fields. -->
            <el-form-item
                v-for="(inputField, index) in vehicleFields"
                :key="inputField.id"
                :label="inputField.label"
                :prop="inputField.prop"
            >
                <component
                    :is="inputField.element"
                    v-model="vehicle[index]"
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
                    v-if="vehicleStore.errors[inputField.prop]"
                    v-text="vehicleStore.errors[inputField.prop]"
                    class="text-red-500 text-xs mt-1"
                ></div>
            </el-form-item>


            <div
                class="flex flex-row"
                v-if="vehicleStore.mode==='create' || vehicleStore.mode==='edit' "
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

<script setup>
import { reactive, ref, watch, onMounted, onActivated, onUpdated, onBeforeMount } from 'vue';
// import type { FormInstance, FormRules } from 'element-plus'
import { useVehicleStore } from '@/Stores/vehicleStore';

let vehicleStore = useVehicleStore();

/**
 * This contains the whole el-form. Needed for the validation.
 */
const ruleFormRef = ref();
/**
 * Here we loop out our input field. Now this looping has two sources:
    1. vehicle: this is for v-model and frontend validation.
    2. vehicleFields: this is hardcoded data, for actually looping out the input fields.
 */
let vehicle = reactive({
    name: '',
    max_weight: '',
    max_pickup_weight: '',
    max_pickup_width: '',
    max_pickup_height: '',
    max_pickup_length: '',
    vehicle_type: '',
    plate_number: '',
    forwarder_id: '',
    address_id: '',
});

/**
 * The vehicle object that is being sent to the backend.
 * This line is creating a reactive object using Vue's reactive function. The reactive function is 
 * used to create a reactive and mutable object. The object is of type TmsVehicle (as defined earlier), 
 * and it's initially set with all properties as empty strings. 
 */
let vehicleFields = reactive({
    name: {
        prop: 'name',
        value: '',
        element: 'el-input',
        label: 'Name',
        type: 'text',
        placeholder: 'Name',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    max_weight: {
        prop: 'max_weight',
        value: '',
        element: 'el-input',
        label: 'Max weight',
        type: 'text',
        placeholder: 'Max weight',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    max_pickup_weight: {
        prop: 'max_pickup_weight',
        value: '',
        element: 'el-input',
        label: 'Max pickup weight',
        type: 'text',
        placeholder: 'Max pickup weight',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    max_pickup_width: {
        prop: 'max_pickup_width',
        value: '',
        element: 'el-input',
        label: 'Max pickup width',
        type: 'text',
        placeholder: 'Max pickup width',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    max_pickup_height: {
        prop: 'max_pickup_height',
        value: '',
        element: 'el-input',
        label: 'Max pickup height',
        type: 'text',
        placeholder: 'Max pickup height',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    max_pickup_length: {
        prop: 'max_pickup_length',
        value: '',
        element: 'el-input',
        label: 'Max pickup length',
        type: 'text',
        placeholder: 'Max pickup length',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    vehicle_type: {
        prop: 'vehicle_type',
        value: '',
        element: 'el-input',
        label: 'Vehicle type',
        type: 'text',
        placeholder: 'Vehicle type',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    plate_number: {
        prop: 'plate_number',
        value: '',
        element: 'el-input',
        label: 'Plate number',
        type: 'text',
        placeholder: 'Plate number',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    forwarder_id: {
        prop: 'forwarder_id',
        value: '',
        element: 'el-input',
        label: 'Forwarder id',
        type: 'text',
        placeholder: 'Forwarder id',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    address_id: {
        prop: 'address_id',
        value: '',
        element: 'el-input',
        label: 'Address id',
        type: 'text',
        placeholder: 'Address id',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
});

/**
 * The validation rules for the form.
 */
const rules = reactive({
    name: [
        { required: true, message: 'Name is required FE', trigger: 'blur' },
        { min: 1, max: 255, message: 'Name length should be between 1 and 255 characters', trigger: 'blur' }
    ],
    max_weight: [
        { required: true, message: 'Max weight is required FE', trigger: 'blur' },
        { min: 1, max: 255, message: 'Max weight length should be between 1 and 255 characters', trigger: 'blur' }
    ],
    max_pickup_weight: [
        { required: true, message: 'Max pickup weight is required FE', trigger: 'blur' },
        { min: 1, max: 255, message: 'Max pickup weight length should be between 1 and 255 characters', trigger: 'blur' }
    ],
    max_pickup_width: [
        { required: true, message: 'Max pickup width is required FE', trigger: 'blur' },
        { min: 1, max: 255, message: 'Max pickup width length should be between 1 and 255 characters', trigger: 'blur' }
    ],
    max_pickup_height: [
        { required: true, message: 'Max pickup height is required FE', trigger: 'blur' },
        { min: 1, max: 255, message: 'Max pickup height length should be between 1 and 255 characters', trigger: 'blur' }
    ],
    max_pickup_length: [
        { required: true, message: 'Max pickup length is required FE', trigger: 'blur' },
        { min: 1, max: 255, message: 'Max pickup length length should be between 1 and 255 characters', trigger: 'blur' }
    ],
    vehicle_type: [
        { required: true, message: 'Vehicle type is required FE', trigger: 'blur' },
        { min: 1, max: 255, message: 'Vehicle type length should be between 1 and 255 characters', trigger: 'blur' }
    ],
    plate_number: [
        { required: true, message: 'Plate number is required FE', trigger: 'blur' },
        { min: 1, max: 255, message: 'Plate number length should be between 1 and 255 characters', trigger: 'blur' }
    ],
    forwarder_id: [
        { required: true, message: 'Forwarder id is required FE', trigger: 'blur' },
    ],
    address_id: [
        { required: true, message: 'Address id is required FE', trigger: 'blur' },
    ],
});

/**
 * Does the frontend validation, and if it is OK, then calls the submit() function.
 */
const emit = defineEmits(['submit']);
const submitForm = async () => {
    // console.log('validation for triggered');
    if (!formEl) return;

    await formEl.validate((valid, fields) => {
        if (valid) {//if validation is OK, then submit the vehicle
            // console.log('FE validation OK, submit! This is the vehicle', vehicle)
            vehicleStore.selectedVehicle = vehicle;
            // console.log('vehicleStore.selectedVehicle:', vehicleStore.selectedVehicle)
            emit('submit');
            
        } else {//if validation is not OK, then show the errors
            // console.log('FE validation not OK, error submit!', fields)
            // console.log('vehicle:', vehicle)
            // console.log('vehicleStore.selectedVehicle:', vehicleStore.selectedVehicle)
        }
    })
}

/**
 * Close the popup, and resets the vehicle values in this component to empty.
 */
let cancel = () => {
    vehicleStore.elDialogVisible = false;
    vehicleStore.selectedVehicle = vehicleStore.customerResetValues;//resetting all vehicle fields
}

/**
 * Update the selectedVehicle object in store. This is needed when the mode is 'show'
 * or 'edit'. Not needed for create mode.
 */
let updateSelectedCustomer = () => {
    vehicleStore.selectedVehicle = vehicle;
}

/**
 * Before this component is mounted, if we are in edit mode, then we have to set the empty vehicle
 * form to be = to the selectedVehicle, that has to be edited.
 */
onBeforeMount(() => {
    if (vehicleStore.mode==='edit') {
        vehicle = vehicleStore.selectedVehicle; 
    }
});

/**
 * Creates dummy vehicles. This is only for testing purposes. 
 */
onMounted(() => {
    if (vehicleStore.mode==='create') {
        vehicle.name = 'BMW';
        vehicle.max_weight = '1000';
        vehicle.max_pickup_weight = '222';
        vehicle.max_pickup_width = '333';
        vehicle.max_pickup_height = '444';
        vehicle.max_pickup_length = '55';
        vehicle.vehicle_type = 'Truck';
        vehicle.plate_number = 'Houston';
        vehicle.forwarder_id = '1';
        vehicle.address_id = '1';
    }
});

</script>

<style scoped>

</style>