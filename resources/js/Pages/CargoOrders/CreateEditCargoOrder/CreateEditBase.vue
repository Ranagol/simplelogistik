<template>

    <Head
        :title="props.mode"
    />

    <!-- <pre>{{ JSON.stringify(data.cargoOrderData, null, 2) }}</pre>   -->

    <!-- EDIT CARGO ORDER -->
    <Card>

        <!-- CARGO ORDER FORM -->
        <Form
            v-model:cargoOrder="data.cargoOrderData"
            :errors="props.errors"
            :mode="props.mode"
            @submit="submit"
            @destroy="destroy"
        />

    </Card>
</template>

<script setup>
import { reactive, ref, onBeforeMount, watch, computed } from 'vue';
import Card from '@/Shared/Card.vue';
import { router } from '@inertiajs/vue3';
import Form from './Form.vue';
import { useEdit } from '@/Use/useEdit';
import { useCreate } from '@/Use/useCreate';
import { useDestroy } from '@/Use/useDestroy';

const props = defineProps({

    /**
     * The cargoOrder object.
     */
    record: {
        type: Object,
        /**
         * The default value is a function that returns an empty cargoOrder object.
         */
        default: () => ({
            internal_oid: 'some_oid', 
            customer_id: 1, 
            contact_id: 1, 
            start_address_id: 1, 
            target_address_id: 1, 
            description: 'some description', 
            shipping_price: 100.00, 
            shipping_price_netto: 80.00, 
            pickup_date: '2023-12-04', 
            delivery_date: '2023-12-05', 
        }),
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

//for developing and testing purposes
const dummyAddress = {
    internal_oid: 'some_oid', 
    customer_id: 1, 
    contact_id: 1, 
    start_address_id: 1, 
    target_address_id: 1, 
    description: 'some description', 
    shipping_price: 100.00, 
    shipping_price_netto: 80.00, 
    pickup_date: '2023-12-04', 
    delivery_date: '2023-12-05', 
};

//for developing and testing purposes
const emptyAddress = {
    internal_oid: '', 
    customer_id: '', 
    contact_id: '', 
    start_address_id: '', 
    target_address_id: '', 
    description: '', 
    shipping_price: '', 
    shipping_price_netto: '', 
    pickup_date: '', 
    delivery_date: '', 
};

const data = reactive({

    /**
     * The cargoOrder object.
     */
    cargoOrderData: props.record,
});

const submit = () => {
    console.log('submit');
    if (props.mode === 'edit') {
        //edits the cargoOrder
        useEdit(
            'cargo-orders',
            data.cargoOrderData.id,
            data.cargoOrderData,
            'cargoOrder',
            'record'
        );

    } else {
        //creates the cargoOrder
        useCreate(
            'cargo-orders',
            data.cargoOrderData,
            'cargoOrder',
            null,
            'http://localhost/cargo-orders'
        );
    }
}

const destroy = () => {
    console.log('destroy');
    //deletes the cargoOrder
    useDestroy(
        `Address will be deleted. Continue?`,
        'cargo-orders',
        data.cargoOrderData.id,
        'cargoOrder',
        null,
        'http://localhost/cargo-orders'
    );
}





</script>

<style scoped>

</style>
