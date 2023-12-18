<template>
    <el-card class="box-card">
        <div class="flex flex-row justify-between">

            <!-- YOUR REFERENCE -->
                <el-form-item
                label="Your reference"
                prop="customer_reference"
            >
                <!-- Here the el-input just receives the customer_reference -->
                <el-input
                    v-model="props.cargoOrder.customer_reference"
                    placeholder="Your reference"
                    @input="updateParent"
                />
                <!-- ...And for every type in el-input, we refresh the parent component
                cargoOrder.customer_reference. Through the updateParent(). Only that.  -->
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.customer_reference"
                />

            </el-form-item>

            <!-- ORDER DATE -->
            <el-form-item
                label="Order date"
                prop="order_created_at"
                class="ml-6"
            >
                <template #default="scope">
                    {{ formatDate(props.cargoOrder.order_created_at) }}
                </template>
            </el-form-item>

            <!-- Imported via -->
            <el-form-item
                label="Origin"
                prop="imported_via"
                class="ml-6"
            >Manually?????</el-form-item>

            <!-- Status -->
            <el-form-item
                label="Status"
                prop="status"
                class="ml-6"
            >Draft????</el-form-item>
        </div>
    </el-card>
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import BackendValidationErrorDisplay from '@/Shared/Validation/BackendValidationErrorDisplay.vue';

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

const emit = defineEmits(['update:cargoOrder']);

/**
 * This function is called when the user types in the el-input. It updates the parent component
 * cargoOrder.customer_reference. It does not triggers anything!
 */
const updateParent = () => {
    emit('update:cargoOrder', props.cargoOrder);
}




</script>