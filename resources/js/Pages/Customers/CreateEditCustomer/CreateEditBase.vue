<template>

    <Head
        :title="props.mode"
    />

    <Card>
        <Tabs
            v-model:customer="data.customerData"
            :errors="errorsComputed"
            :mode="props.mode"
            @submit="submit"
            @destroy="destroy"
        />
    </Card>
    
</template>

<script setup>
import { reactive, ref, onBeforeMount, watch, computed } from 'vue';

import Card from '@/Shared/Card.vue';
import { router } from '@inertiajs/vue3'
import { useEdit } from '@/Use/useEdit';
import { useCreate } from '@/Use/useCreate';
import { useDestroy } from '@/Use/useDestroy';
import _ from 'lodash';
import Tabs from '@/Pages/Customers/CreateEditCustomer/Tabs.vue';


const props = defineProps({

    /**
     * The customer object.
     */
    record: {
        type: Object,
        default: () => ({
            "internal_cid": "C000",
            "first_name": "John",
            "last_name": "Doe",
            "company_name": "Belladonna",
            "email": 'random text',
            "tax_number": 'random text',
            "rating": 'random text',
            "auto_book_as_private": true,
            "dangerous_goods": true,
            "bussiness_customer": true,
            "debt_collection": true,
            "direct_debit": true,
            "manual_collective_invoicing": true,
            "only_paypal_sofort_amazon_vorkasse": true,
            "private_customer": true,
            "invoice_customer": true,
            "poor_payment_morale": true,
            "can_login": true,
            "customer_type": 1,
            "invoice_dispatch": true,
            "invoice_shipping_method": true,
            "payment_method": true
        })
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

/**
 * This watcher simply helps to validation errors from props.errors to go to the child components.
 * For some reason this is not reactive enough without the computed.
 */
let errorsComputed = computed(() => {
    return props.errors;
});



const data = reactive({

    /**
     * The customer object.
     */
    customerData: props.record
});

const dummyCustomer = {
    "internal_cid": "C000",
    "first_name": "John",
    "last_name": "Doe",
    "company_name": "Belladonna",
    "email": 'random text',
    "tax_number": 'random text',
    "rating": 'random text',
    "auto_book_as_private": true,
    "dangerous_goods": true,
    "bussiness_customer": true,
    "debt_collection": true,
    "direct_debit": true,
    "manual_collective_invoicing": true,
    "only_paypal_sofort_amazon_vorkasse": true,
    "private_customer": true,
    "invoice_customer": true,
    "poor_payment_morale": true,
    "can_login": true,
    "customer_type": 1,
    "invoice_dispatch": true,
    "invoice_shipping_method": true,
    "payment_method": true
}

const emptyCustomer = {
    "internal_cid": "",
    "first_name": "",
    "last_name": "",
    "company_name": "",
    "email": "",
    "tax_number": "",
    "rating": "",
    "auto_book_as_private": "",
    "dangerous_goods": "",
    "bussiness_customer": "",
    "debt_collection": "",
    "direct_debit": "",
    "manual_collective_invoicing": "",
    "only_paypal_sofort_amazon_vorkasse": "",
    "private_customer": "",
    "invoice_customer": "",
    "poor_payment_morale": "",
    "can_login": true,
    "customer_type": "",
    "invoice_dispatch": "",
    "invoice_shipping_method": "",
    "payment_method": ""
}


const submit = () => {
    console.log('submit from CreateEditBase.vue');
    if (props.mode === 'edit') {
        //edits the customer
        useEdit(
            'customers', 
            data.customerData.id,
            data.customerData,
            'customer',
            'record'
        );

    } else {
        //creates the customer
        useCreate(
            'customers', 
            data.customerData,
            'customer',
            null,
            'http://localhost/customers'
        );
    }
}

const destroy = () => {
    console.log('destroy');
    //deletes the customer
    useDestroy(
        `Customer will be deleted. Continue?`,
        'customers', 
        data.customerData.id,
        'customer',
        null,
        'http://localhost/customers'
    );
}










</script>

<style scoped>

</style>