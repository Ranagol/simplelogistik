<template>
    <el-form
        ref="elFormRef"
        :model="data.cargoOrder"
        :rules="rules"
    >   
        <!-- HEADER WITH DELETE AND SUBMIT BUTTON -->
        <!-- Notice: whenever there is a 'submit emit from Header, the submit()
            is triggered, AND it receives the elformRef, which is the el-form
            itself. This is the secret for the FE validation.' -->
        <!-- <Header
            :errors="props.errors"
            :mode="props.mode"
            @submit="submit(elFormRef)"
            @destroy="destroy"
        /> -->

        <!-- DETAILS -->
        <Details
            v-model:cargoOrder="data.cargoOrder"
            :errors="props.errors"
            :mode="props.mode"
        />

        <!-- ADDRESSES -->
        <div class="flex flex-row">

            <Address
                v-model:address="data.cargoOrder.customer.headquarter"
                :errors="props.errors"
                :mode="props.mode"
                title="Customer"
                class="grow"
            />

            <!-- This is just an empty divider between columns -->
            <div class="w-4"></div>

            <!-- PICKUP ADDRESS -->
            <Address
                v-model:address="data.cargoOrder.start_address"
                :errors="props.errors"
                :mode="props.mode"
                title="Pickup"
                class="grow"
            />

            <!-- This is just an empty divider between columns -->
            <div class="w-4"></div>

            <!-- DELIVERY ADDRESS -->
            <Address
                v-model:address="data.cargoOrder.target_address"
                :errors="props.errors"
                :mode="props.mode"
                title="Delivery"
                class="grow"
            />

        </div>

        <!-- PARCELLS -->
        <Parcels
            v-model:parcels="data.cargoOrder.parcels"
            :errors="props.errors"
            :mode="props.mode"
        />

        <br>

        <pre>{{ JSON.stringify(props.cargoOrder, null, 2) }}</pre>

    </el-form>


</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import _ from 'lodash';
import Header from './Header.vue';
import Title from '@/Shared/Title.vue';
import Details from './Details.vue';
import Address from './Address.vue';
import Parcels from './Parcels.vue';

let props = defineProps({

    /**
     * The carogOrder object.
     */
    cargoOrder: {
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
});

let data = reactive({
    cargoOrder: props.cargoOrder
});

/**
 * This does the customer data synchronization with the parent CreateEditBase component. With
 * v-model magic. This is not sending a signal for saving the customer! Just the data.customer.
 */
 const emit = defineEmits(['update:cargoOrder', 'submit', 'destroy']);

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

    console.log('submit from DataTab.vue')
    validate(elFormRef);
}

/**
 * Does the frontend validation, and if it is OK, then emits the signal for creating/editing. That
 * signal is received by the parent CreateEditAddress.vue component. If it is not ok, then:
 * 1. there will be red error messages under the relevant fields
 * 2. no emit will happen
 */
 const validate = async (elFormRef) => {
    console.log('submit() called, FE validation starts')
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