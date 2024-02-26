<template>

    <!-- INPUT FIELDS START HERE.  -->
    <div
        class="grid grid-cols-4 gap-4 mt-4"
    >

        <!-- LOADING METER -->
        <el-form-item
            prop="p_loading_meter"
        >   
            <div class="flex flex-col">

                <!-- LABEL -->
                <span
                    v-if="data.showLabel"
                    class="ml-1"
                >Loading meter</span>
                
                <!-- INPUT -->
                <el-input
                    v-model="data.order.p_loading_meter"
                    placeholder="Loading meter"
                    clearable
                    @input="updateParent"
                />

            </div>
            
            <BackendValidationErrorDisplay
                :errorMessage="props.errors.p_loading_meter"
            />

        </el-form-item>

        <!-- SQUARE METER -->
        <el-form-item
            prop="p_square_meter"
        >   
            <div class="flex flex-col">

                <!-- LABEL -->
                <span
                    v-if="data.showLabel"
                    class="ml-1"
                >Square meter</span>
                
                <!-- INPUT -->
                <el-input
                    v-model="data.order.p_square_meter"
                    placeholder="Square meter"
                    clearable
                    @input="updateParent"
                />

            </div>
            
            <BackendValidationErrorDisplay
                :errorMessage="props.errors.p_square_meter"
            />

        </el-form-item>

        <!-- TOTAL WEIGHT -->
        <el-form-item
            prop="p_total_weight"
        >   
            <div class="flex flex-col">

                <!-- LABEL -->
                <span
                    v-if="data.showLabel"
                    class="ml-1"
                >Total weight</span>
                
                <!-- INPUT -->
                <el-input
                    v-model="data.order.p_total_weight"
                    placeholder="Total weight (kg)"
                    clearable
                    @input="updateParent"
                />

            </div>
            
            <BackendValidationErrorDisplay
                :errorMessage="props.errors.p_total_weight"
            />

        </el-form-item>

        <!-- QUBIC METER -->
        <el-form-item
            prop="p_qubic_meter"
        >   
            <div class="flex flex-col">

                <!-- LABEL -->
                <span
                    v-if="data.showLabel"
                    class="ml-1"
                >Qubic meter</span>
                
                <!-- INPUT -->
                <el-input
                    v-model="data.order.p_qubic_meter"
                    placeholder="Qubic meter"
                    clearable
                    @input="updateParent"
                />

            </div>
            
            <BackendValidationErrorDisplay
                :errorMessage="props.errors.p_qubic_meter"
            />

        </el-form-item>
    
    </div>
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import BackendValidationErrorDisplay from '@/Shared/Validation/BackendValidationErrorDisplay.vue';

const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
    mode: {
        type: String,
        required: true,
    },
});

const data = reactive({
    showLabel: true,
    order: props.order,
});

const emit = defineEmits(['update:order']);

/**
 * This function is called when the user types in the el-input. It updates the parent component
 * order.customer_reference. It does not triggers anything!
 */
const updateParent = () => {
    emit('update:order', data.order);
}

</script>