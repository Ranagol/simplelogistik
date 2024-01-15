<template>

    <Head
        :title="props.mode"
    />

    <!-- <pre>{{ JSON.stringify(data.addressData, null, 2) }}</pre>   -->

    <!-- EDIT ADDRESS -->
    <Card>

        <div class="flex justify-end">
            <!-- SUBMIT BUTTON -->
            <el-form-item>
                <el-button
                    @click="submit(elFormRef)"
                    type="primary"
                    name="button"
                >Submit</el-button>
            </el-form-item>


            <!-- DELETE BUTTON -->
            <el-form-item
                v-if="props.mode === 'edit'"
                class="ml-4"
            >
                <el-button
                    @click="destroy"
                    type="danger"
                    name="button"
                >Delete</el-button>
            </el-form-item>
        </div>


        <!-- NEW ADDRESS FORM -->
        <Address
            v-model:address="data.addressData"
            :errors="props.errors"
            :mode="props.mode"
            :addressTypes="props.addressTypes"
            :customers="props.customers"
            :forwarders="props.forwarders"
            :partners="props.partners"
            :countries="props.countries"
            :showAvisPhone="false"
            :showComment="false"
            :showCustomer="true"
            :showForwarder="true"
            :showPartner="true"
            class="grow"
        />

    </Card>
</template>

<script setup>
import { reactive, ref, onBeforeMount, watch, computed } from 'vue';
import Card from '@/Shared/Card.vue';
import { router } from '@inertiajs/vue3';
import Address from './Address.vue';
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
        required: true
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
        required: false
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

    countries: {
        type: Array,
        required: true
    },

    partners: {
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
