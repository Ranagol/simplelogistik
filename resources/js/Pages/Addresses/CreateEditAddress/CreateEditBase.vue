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
            :customers="props.customers"
            :forwarders="props.forwarders"
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
//@ = Pages
import addressDummy from '@/Pages/Addresses/CreateEditAddress/addressDummy';//use this in props to have already filled address form for creating new address
import addressEmpty from '@/Pages/Addresses/CreateEditAddress/addressEmpty';//use this in props to have empty address form for creating new address

const props = defineProps({

    /**
     * The address object.
     */
    record: {
        type: Object,
        /**
         * The default value is a function that returns an empty address object.
         */
        default: () => (addressDummy),
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

    customers: {
        type: Array,
        required: true
    },

    forwarders: {
        type: Array,
        required: true
    },
});

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
            null,
            'http://localhost/addresses'
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
