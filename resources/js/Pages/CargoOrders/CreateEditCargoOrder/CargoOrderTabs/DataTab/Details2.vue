<template>
    <div class="mt-5 mb-5 grid grid-cols-5">
        
        <el-form-item
            v-for="(value, key, index) in selectedOrderProperties"
            :key="index"
            :prop="value"
        >

            <el-tooltip
                :content="key"
                placement="top"
                :auto-close="400"
            >
                <div class="flex flex-col mr-2">

                    <span class="ml-1">{{ key }}</span>

                    <el-input
                        v-model="props.cargoOrder[key]"
                        :placeholder="key"
                        @input="updateParent"
                    />
                </div>

            </el-tooltip>
            
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

/**
 * We do not want to display all the order properties, only some.
 */
let selectedOrderProperties = computed(
    () => {
  	    return props.cargoOrder;
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