<template>

    <Head
        :title="props.mode"
    />

    <Card>
        <Tabs
            v-model:customer="data.customerData"
            :errors="errorsComputed"
            :mode="props.mode"
            :selectOptions="props.selectOptions"
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
        required: true
    },

    /**
     * These are the possibly selectable options for the el-select in customer create or edit form.
     * The options are fetched from the backend.
     */
    selectOptions: Object,

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
 * This simply helps to validation errors from props.errors to go to the child components.
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

/**
 * This watcher is needed for comment creating. When a comment is created, the backend sends back
 * the updated customer object, and we need to update the customer object in this component. But,
 * only the comments property of the customer object is updated. Which is a nested property update.
 * Vue can't see this change, without this watcher. But, with this watcher, Vue can see the change.
 * Then the customer with the new comments arrives to data. Then it is automatically passed to the
 * child component. Which is what we wanted.
 */
watch(
    () => props.record, 
    (newValue, oldValue) => {
        data.customerData = newValue;
    },
    { deep: true }
);

const emptyCustomer = {
    internal_id: "C000",
    first_name: "John",
    last_name: "Doe",
    company_name: "Belladonna",
    email: 'bla@gmail.com',
    tax_number: 'random text',
    rating: 5,
    auto_book_as_private: true,
    dangerous_goods: true,
    bussiness_customer: true,
    debt_collection: true,
    direct_debit: true,
    manual_collective_invoicing: true,
    only_paypal_sofort_amazon_vorkasse: true,
    private_customer: true,
    invoice_customer: true,
    poor_payment_morale: true,
    can_login: true,

    customer_type: "Bussiness customer",
    invoice_dispatch: "Direct",
    invoice_shipping_method: "Email",
    payment_method: "Paypal"
}


const submit = () => {
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
            null
        );
    }
}

const destroy = () => {
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