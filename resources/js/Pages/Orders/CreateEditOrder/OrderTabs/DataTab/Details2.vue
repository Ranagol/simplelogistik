<template>

    <!-- TITLE AND SWITCH-->
    <div class="flex justify-between mt-6">
        <Title 
            title="Temporary Details2" 
            class="mt-4 mb-2"
        />

        <el-switch
            v-model="data.showDetails2"
        ></el-switch>
    </div>


    <div 
        v-if="data.showDetails2"
        class="mt-5 mb-5 grid grid-cols-5"
    >
        
        <el-form-item
            v-for="(value, key, index) in selectedOrderProperties"
            :key="index"
            :prop="value"
        >

            <div class="flex flex-col mr-2">

                <span class="ml-1">{{ key }}</span>

                <el-input
                    v-model="props.order[key]"
                    :placeholder="key"
                    @input="updateParent"
                />
            </div>

            
            <BackendValidationErrorDisplay
                :errorMessage="props.errors.customer_reference"
            />

        </el-form-item>

    </div>

</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import BackendValidationErrorDisplay from '@/Shared/Validation/BackendValidationErrorDisplay.vue';
import { useDateFormatter } from '@/Use/useDateFormatter';
import Title from '@/Shared/Title.vue';

const props = defineProps({
    order: {
        type: Object,
        required: true
    },
    errors: {
        type: Object,
        required: true
    },
    mode: {
        type: String,
        required: true
    },
});

let data = reactive({
    showDetails2: false,
});

/**
 * We do not want to display all the order properties, only some. Order properties that should 
 * not be displayed are listed in dontDisplayThese array. 
 */
let selectedOrderProperties = computed(
    () => {
        const dontDisplayThese = [
            'id', 'origin', 'order_edited_events', 'p_order_pdf', 'parcels', 
            'pickup_address', 'delivery_address', 'updated_at', 'created_at',
            'customer', 'pickup_address_id', 'delivery_address_id', 'customer_reference',
            'customer_id', 'contact_id', 'p_order_number', 'order_date', 'type_of_transport',
            'p_payment_method', 'p_date_of_sale', 'p_date_of_cancellation',
            'p_loading_meter', 'p_total_weight', 'p_qubic_meter', 'p_square_meter',
            'purchase_price', 'p_transport_price_vat', 'p_transport_price_net', 'p_distance_km',
            'p_duration_minutes',

            'month_and_year', 'p_calculation_model_name', 'p_pickup_date_from', 'p_pickup_date_to',
            'p_delivery_date_from', 'p_delivery_date_to', 
            'provision', 'currency', 'p_calculated_transport_price', 'p_transport_price_gross',
            'p_customized_price_change', 'p_customized_price_mode', 'p_discount', 'p_price_gross',
            'p_price_net', 'p_price_vat', 'p_price_fuel_surcharge', 'p_vat_rate', 'p_value_insured',
            'p_value_of_goods'
        ];
        const newOrder = {};//this will contain all order properties, that are needed for display.
        for (const [key, value] of Object.entries(props.order)) {
            if (!dontDisplayThese.includes(key)) {
                newOrder[key] = value;
            }
        }
  	    return newOrder; 
    }
);


const emit = defineEmits(['update:order']);

/**
 * This function is called when the user types in the el-input. It updates the parent component
 * order.customer_reference. It does not triggers anything!
 */
const updateParent = () => {
    emit('update:order', props.order);
}
</script>