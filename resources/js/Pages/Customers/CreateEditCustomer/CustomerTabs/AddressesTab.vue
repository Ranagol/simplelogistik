<template>
    <!-- <slot name="buttonSubmitTab"></slot> -->
    <!-- <pre>{{ JSON.stringify(data.customer, null, 2) }}</pre> -->
    
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';

let props = defineProps({
    modelValue: {
        type: Object,
        required: true
    }
});

let data = reactive({
    customer: props.modelValue
});

/**
 * This does the customer data synchronization with the parent CreateEditBase component. With
 * v-model magic. This is not sending a signal for saving the customer! Just the customer.
 */
const emit = defineEmits(['update:modelValue']);
function handleChange(){
    emit('update:modelValue', data.customer);
}



</script>

<style scoped>
</style>