<template>

    <!-- TITLE AND SWITCH-->
    <div class="flex justify-between">
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
                    v-model="props.cargoOrder[key]"
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
    cargoOrder: {
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
    showDetails2: true,
});

/**
 * We do not want to display all the order properties, only some. Order properties that should 
 * not be displayed are listed in dontDisplayThese array. 
 */
let selectedOrderProperties = computed(
    () => {
        const dontDisplayThese = [
            'id', 'origin', 'order_edited_events', 'p_order_pdf', 'parcels', 
            'start_address', 'target_address', 'updated_at', 'created_at',
            'customer', 'pickup_address_id', 'delivery_address_id', 'customer_reference',
            'customer_id', 'contact_id', 'p_order_number', 'order_date', 'type_of_transport',
            'p_payment_method', 'p_date_of_sale', 'p_date_of_cancellation'
        ];
        const newOrder = {};//this will contain all order properties, that are needed for display.
        for (const [key, value] of Object.entries(props.cargoOrder)) {
            if (!dontDisplayThese.includes(key)) {
                newOrder[key] = value;
            }
        }
  	    return newOrder; 
    }
);


const emit = defineEmits(['update:cargoOrder']);

/**
 * This function is called when the user types in the el-input. It updates the parent component
 * cargoOrder.customer_reference. It does not triggers anything!
 */
const updateParent = () => {
    emit('update:cargoOrder', props.cargoOrder);
}
</script>