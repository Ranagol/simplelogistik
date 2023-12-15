<template>

    <Head
        :title="props.mode"
    />

    <!-- CREATE EDIT CARGO ORDER -->
    <Card>
        
        <Tabs
            v-model:cargoOrder="data.cargoOrderData"
            :errors="props.errors"
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
import { router } from '@inertiajs/vue3';
// import Form from './Form.vue';
import { useEdit } from '@/Use/useEdit';
import { useCreate } from '@/Use/useCreate';
import { useDestroy } from '@/Use/useDestroy';
import Tabs from './Tabs.vue';
import orderDummy from './orderDummy';
import orderEmpty from './orderEmpty';

const props = defineProps({

    /**
     * The cargoOrder object.
     */
    record: {
        type: Object,
        /**
         * The default value is a function that returns an empty cargoOrder object.
         */
        default: () => (orderDummy),

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

const data = reactive({

    /**
     * The cargoOrder object.
     */
    cargoOrderData: props.record,
});

//for developing and testing purposes
const emptyCargoOrder = {
    id: 1,
    description: "A tempore dicta et eum voluptates.",
    type_of_transport: "Special order",
    origin: "Pamyra",
    customer_reference: "Voluptatem sequi ipsum.",
    shipping_price: "65.75",
    shipping_price_netto: "18.63",
    provision: null,
    order_edited_events: null,
    customer_id: 1,
    contact_id: 1,
    pickup_address_id: 1,
    delivery_address_id: 2,
    avis_customer_phone: "+16784136577",
    avis_sender_phone: "+1.786.418.2544",
    avis_receiver_phone: "667-421-9304",
    p_calculation_model_name: "sit",
    p_order_number: "Order 8905",
    p_order_pdf: "http://lakin.net/",
    p_payment_method: "Bank Transfer",
    p_date_of_sale: "1978-08-22",
    p_date_of_cancellation: "1983-12-07",
    p_pickup_date_from: "2023-12-20 03:50:22",
    p_pickup_date_to: "2023-12-22 23:16:37",
    p_pickup_comments: "Cumque nihil repellat omnis neque autem vero ut.",
    p_delivery_date_from: "2023-12-30 08:04:33",
    p_delivery_date_to: "2024-01-05 14:11:17",
    p_delivery_comments: "Voluptatum modi totam rerum.",
    p_description_of_transport: "Qui vel velit vel quia ea quisquam.",
    p_particularities: "Sunt quaerat minus laudantium ullam atque eum.",
    p_loading_meter: "98.63",
    p_square_meter: "46.16",
    p_total_weight: "37.74",
    p_qubic_meter: "88.66",
    p_calculated_transport_price: "485.26",
    p_transport_price_gross: "54",
    p_transport_price_vat: "163.29",
    p_transport_price_net: "114.17",
    p_customized_price_change: "59.21",
    p_customized_price_mode: "decrease",
    p_discount: "45.5",
    p_price_gross: "83.75",
    p_price_vat: "2.21",
    p_price_net: "317.52",
    p_price_fuel_surcharge: "78.73",
    p_vat_rate: "9.64",
    p_value_insured: "5384.6",
    p_value_of_goods: "4371.51",
    p_distance_km: "482.41",
    p_duration_minutes: "530",
};



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
