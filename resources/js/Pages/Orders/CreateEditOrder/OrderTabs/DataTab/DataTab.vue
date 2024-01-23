<template>
    <el-form
        ref="elFormRef"
        :model="data.order"
        :rules="rules"
    >   

        <!-- GENERAL DATA: reference, date, origin, status-->
        <GeneralData
            v-model:order="data.order"
            :errors="props.errors"
            :mode="props.mode"
            :selectOptions="props.selectOptions"
        />

        <!-- ADDRESSES -->
        <!-- <AddressBase
            v-model:order="data.order"
            :errors="props.errors"
            :mode="props.mode"
            :countries="props.selectOptions.countries"
        /> -->

        <!-- PARCELLS -->
        <!-- <ParcelBase
            v-model:order="data.order"
            :errors="props.errors"
            :mode="props.mode"
            :selectOptions="props.selectOptions"
        /> -->

        <!-- FINANCES -->
        <!-- <FinanceBase
            v-model:order="data.order"
            :errors="props.errors"
            :mode="props.mode"
        /> -->

        <!-- VEHICLE REQUIREMENTS -->
        <!-- <VehicleReqBase
            v-model:order="data.order"
            :errors="props.errors"
            :mode="props.mode"
        /> -->
        

        <pre>{{ JSON.stringify(props.order, null, 2) }}</pre>

    </el-form>


</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import _ from 'lodash';
import GeneralData from './GeneralData/GeneralData.vue';
import AddressBase from './Addresses/AddressBase.vue';
import ParcelBase from './Parcels/ParcelBase.vue';
import { useOrderStore } from '@/Stores/orderStore';
import FinanceBase from './Finances/FinanceBase.vue';
import VehicleReqBase from './VehicleRequirements/VehicleReqBase.vue';

let props = defineProps({

    /**
     * The carogOrder object.
     */
    order: {
        type: Object,
        required: true
    },

    /**
     * The errors object that is sent from the backend, and contains the validation errors.
     */
    errors: Object,

    /**
     * mode is either 'create' or 'edit'. This is decided in the controller. This component will
     * behave differently depending on which mode is it.
     */
    mode: {
        type: String,
        required: true
    },

    selectOptions: Object,
});

let data = reactive({
    order: props.order,
});

/**
 * This does the customer data synchronization with the parent CreateEditBase component. With
 * v-model magic. This is not sending a signal for saving the customer! Just the data.customer.
 */
 const emit = defineEmits(['update:order', 'submit', 'destroy']);

/**
 * Here we only update the parent's customer, using v-model magic. This is not sending a signal.
 */
 const update = () =>{
    emit('update:modelValue', data.customer);
}


const destroy = () => {
    emit('destroy');
}


//*************************** FRONTEND FORM VALIDATION ***************************//
let orderStore = useOrderStore();
watch(
    () => orderStore.triggerOrderSubmit,
    (newValue, oldValue) => {
        if (newValue === true) {
            submit(elFormRef);
        }
    }
);

/**
 * This contains the whole el-form. Needed for the validation.
 */
 const elFormRef = ref();

/**
 * Starts the submitting proces. First step: frontend validation. It takes the el-form as an
 * argument. This is possible, because the el-form is captured in const elFormRef = ref(); The
 * el-form has the logic for FE validation. 
 */
 const submit = (elFormRef) => {

    emit('submit');//this goes back to grandparent CreateEditBase.vue
    orderStore.triggerOrderSubmit = false;//Here we reset the trigger from the orderStore.


    // validate(elFormRef);//Here I turned off the FE validation
}

/**
 * THIS IS TURNED OFF!!!!!!!!!!!!!!!!!
 * Does the frontend validation, and if it is OK, then emits the signal for creating/editing. That
 * signal is received by the parent CreateEditAddress.vue component. If it is not ok, then:
 * 1. there will be red error messages under the relevant fields
 * 2. no emit will happen
 */
 const validate = async (elFormRef) => {
    console.log('submit() called, FE validation starts')
    console.log('elFormRef:', elFormRef)
    if (!elFormRef) return;

    await elFormRef.validate((valid, fields) => {
        
        if (valid) {
            //if validation is OK, then submit
            console.log('FE validation OK, submit!', fields)
            emit('submit');//this goes back to grandparent CreateEditBase.vue
        
        } else {
            //if validation is not OK, then log the problematic validation fields
            console.log('FE validation not OK, error submit!', fields)
        }
    });
}

/**
 * The FE validation rules for the form. We import this from a separate file, because it is too
 * long to be here.
 */
const rules = reactive({
    // customer_reference: [
    //     { required: true, message: 'Please input your customer reference', trigger: 'blur' },
    // ]
});

</script>