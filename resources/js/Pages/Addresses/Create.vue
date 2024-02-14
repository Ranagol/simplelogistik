<template>
    <Card class="shadow">
        <div class="grid grid-cols-4 gap-4 grid-flow-roww">
            <div v-for="field, index in formSettings" :class="field.class">
                <IconTooltipInput v-if="field.type === 'text'" :key="'address-field-' + index" :placeholder="field.placeholder"></IconTooltipInput>
                <div v-else-if="field.type === 'check'">
                    <div v-for="option in field.options">
                        <label class="grid justify-start grid-flow-col place-items-center">
                            <input type="checkbox" name="" id="" :value="option.key" />
                            <span class="ps-2">{{ $t(option.label) }}</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </Card>
</template>

<script setup>
import IconTooltipInput 
    from '@/Components/Inputs/IconTooltipInput.vue';
    
import Card 
    from '@/Shared/Card.vue';
    
import { router } 
    from '@inertiajs/vue3';
import axios from 'axios';
    
import { reactive, ref } 
    from 'vue';

const props = defineProps({
    customers: Array,
    forwarders: Array,
    countries: Array,
    partners: Array,
});

var Customers = ref(props.customers ?? []);
var Forwarders = ref(props.forwarders  ?? []);
var Countries = ref(props.countries ?? []);
var Partners = ref(props.partners ?? []);

const getAddressTypes = () => {
    return [
        {
            key: "is_pickup",
            label: "labels.pickup-address",
            default: false
        },
        {
            key: "is_delivery",
            label: "labels.delivery-address",
            default: false
        },
        {
            key: "is_billing",
            label: "labels.billing-address",
            default: false
        },
        {
            key: "is_headquarter",
            label: "labels.headquarter-address",
            default: false
        }
    ]
}

const formSettings = reactive({
    address_type: {       
        type: 'check',
        options: getAddressTypes(),
        class: "col-span-4",
        label: 'Address Type',
        placeholder: 'Address Type',
        tooltip: 'The type of the address',
        required: true,    
    },
    company_name: {
        type: 'text',
        class: "col-span-4",
        label: 'Company Name',
        placeholder: 'Company Name',
        icon: 'business',
        tooltip: 'The name of the company',
        required: true,
    },
    first_name: {
        type: 'text',
        class: "col-span-2",
        label: 'First Name',
        placeholder: 'First Name',
        icon: 'person',
        tooltip: 'The first name of the contact person',
        required: true, 
    },
    last_name: {
        type: 'text',
        class: "col-span-2",
        label: 'Last Name',
        placeholder: 'Last Name',
        icon: 'person',
        tooltip: 'The last name of the contact person',
        required: true,         
    },
    street: {
        type: 'text',
        class: "col-span-3",
        label: 'Street',
        placeholder: 'Street',
        tooltip: 'The street of the address',
        required: true,
    },
    house_number: {       
        type: 'text',
        class: "col-span-1",
        label: 'House Number',
        placeholder: 'House Number',
        tooltip: 'The house number of the address',
        required: true,    
    },
    zip_code: {        
        type: 'text',
        class: "col-span-1",
        label: 'Zip Code',
        placeholder: 'Zip Code',
        tooltip: 'The zip code of the address',
        required: true,
    },
    city: {       
        type: 'text',
        class: "col-span-3",
        label: 'City',
        placeholder: 'City',
        tooltip: 'The city of the address',
        required: true,
    },
    country: {        
        type: 'select',
        class: "col-span-4",
        options: Countries,
        label: 'Country Code',
        placeholder: 'Country Code',
        tooltip: 'The country code of the address',
        required: true,
    },
    email: {       
        type: 'text',
        class: "col-span-4",
        label: 'Email',
        placeholder: 'Email',
        tooltip: 'The email of the contact person',
        required: true,
    },
    phone: {        
        type: 'text',
        class: "col-span-4",
        label: 'Phone',
        placeholder: 'Phone',
        tooltip: 'The phone of the contact person',
        required: true,
    },
    state: {       
        type: 'text',
        class: "col-span-4",
        label: 'State',
        placeholder: 'State',
        tooltip: 'The state of the address',
        required: true,
    },
    address_additional_information: {        
        type: 'text',
        class: "col-span-4",
        label: 'Address Additional Information',
        placeholder: 'Address Additional Information',
        tooltip: 'Additional information about the address',
        required: true,
    },
    customer_id: {
        type: 'select',
        class: "col-span-4",
        options: Customers,
        label: 'Customer ID',
        placeholder: 'Customer ID',
        tooltip: 'The customer id of the address',
        required: true,
    },
    forwarder_id: {
        type: 'select',
        class: "col-span-4",
        options: Forwarders,
        label: 'Forwarder ID',
        placeholder: 'Forwarder ID',
        tooltip: 'The forwarder id of the address',
        required: true,
    },
    forwarder_id: {
        type: 'select',
        class: "col-span-4",
        options: Partners,
        label: 'Partner',
        placeholder: 'Partner ID',
        tooltip: 'The forwarder id of the address',
        required: true,
    },
})

const formData = ref({
    company_name: '',
    first_name: '',
    last_name: '',
    address_types: {
        is_pickup: false,
        is_delivery: false,
        is_billing: false,
        is_headquarter: false,
    },
    street: '',
    house_number: '',
    zip_code: '',
    city: '',
    country_code: '',
    email: '',
    phone: '',
    state: '',
    type_of_address: '',
    address_additional_information: '',
    customer_id: '',
    forwarder_id: '',
});

</script>
