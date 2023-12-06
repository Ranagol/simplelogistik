<template>

    <Head
        :title="props.mode"
    />

    <!-- <pre>{{ JSON.stringify(data.addressData, null, 2) }}</pre>   -->

    <!-- EDIT ADDRESS -->
    <Card>

        <!-- ADDRESS FORM -->
        <Form
            v-model:address="data.addressData"
            :errors="props.errors"
            :mode="props.mode"
            :addressTypes="props.addressTypes"
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
     * The address object.
     */
    record: {
        type: Object,
        /**
         * The default value is a function that returns an empty address object.
         */
        default: () => ({
            first_name: 'Random text',
            last_name: 'Random text',
            address_type: 'Main headquarters',
            street: "Random text",
            house_number: 'Random text',
            zip_code: "Random text",
            city: "Random text",
            country: "Random text",
            state: 'Random text',
            type_of_address: '',
            comment: 'Random text',
            customer_id: 1,
            forwarder_id: 1,
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
     * The address types that are defined in TmsAddress model. The backend is sending this data here.
     */
    addressTypes: {
        type: Object,
        required: true
    },

    /**
     * The errors object that is sent from the backend, and contains the validation errors.
     */
    errors: Object,
});

//for developing and testing purposes
const dummyAddress = {
    first_name: 'Random text',
    last_name: 'Random text',
    address_type: 'Main headquarters',
    street: "Random text",
    house_number: 'Random text',
    zip_code: "Random text",
    city: "Random text",
    country: "Random text",
    state: 'Random text',
    type_of_address: '',
    comment: 'Random text',
    customer_id: 1,
    forwarder_id: 1,
};

//for developing and testing purposes
const emptyAddress = {
    first_name: null,
    last_name: null,
    address_type: null,
    street: "",
    house_number: null,
    zip_code: "",
    city: "",
    country: "",
    state: null,
    type_of_address: null,
    comment: null,
    customer_id: null,
    forwarder_id: null,
};

const data = reactive({

    /**
     * The address object.
     */
    addressData: props.record,
});

const submit = () => {
    console.log('submit');
    if (props.mode === 'edit') {
        //edits the address
        useEdit(
            'addresses', 
            data.addressData.id,
            data.addressData,
            'address',
            'record'
        );

    } else {
        //creates the address
        useCreate(
            'addresses', 
            data.addressData,
            'address',
            'record'
        );
    }
}

const destroy = () => {
    console.log('destroy');
    //deletes the address
    useDestroy(
        `Address will be deleted. Continue?`,
        'addresses', 
        data.addressData.id,
        'address',
        null,
        'http://localhost/addresses'
    );
}





</script>

<style scoped>

</style>