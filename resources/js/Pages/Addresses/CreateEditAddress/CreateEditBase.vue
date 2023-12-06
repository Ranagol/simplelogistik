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
            @submit="submit"
        />

    </Card>
</template>

<script setup>
import { reactive, ref, onBeforeMount, watch, computed } from 'vue';
import Card from '@/Shared/Card.vue';
import { router } from '@inertiajs/vue3';
import Form from './Form.vue';

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
            id: null,
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
            created_at: null,
            updated_at: null
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

/**
 * This watcher simply helps to validation errors from props.errors to go to the child components.
 * For some reason this is not reactive enough without the computed.
 */
let errorsComputed = computed(() => {
    return props.errors;
});



const data = reactive({

    /**
     * The address object.
     */
    addressData: props.record
});

const submit = () => {
    console.log('submit');
    if (props.mode === 'edit') {
        edit();
    } else {
        create();
    }
}

const edit = () => {
    router.put(
        `/addresses/${data.addressData.id}`, 
        data.addressData,
        {
            onSuccess: () => {
                ElMessage({
                    message: 'Address edited successfully',
                    type: 'success',
                });
                router.reload({ only: ['record'] })
            },
            onError: (errors) => {
                ElMessage.error('Oops, something went wrong while editing a address.')
                ElMessage(errors);
            }
        }
    )
};

// const create = () => {
//     router.post(
//         '/addresses', 
//         customerStore.selectedCustomer, 
//         {
//             onSuccess: () => {
//                 ElMessage({
//                     message: 'Address created successfully',
//                     type: 'success',
//                 });
//                 // get addresses again, so that the new address is displayed
//                 router.reload({ only: ['dataFromController'] })
//                 customerStore.elDialogVisible = false;
//             },
//             onError: (errors) => {
//                 ElMessage.error('Oops, something went wrong while creating a new address.')
//                 ElMessage(errors);
//             }
//         }
//     )
// };




/**
 * Resets the address values in this component to empty.
 */
let cancel = () => {
}

/**
 * Update the selectedCustomer object in store. This is needed when the mode is 'show'
 * or 'edit'. Not needed for create mode.
 */
let update = () => {
    
}




</script>

<style scoped>

</style>