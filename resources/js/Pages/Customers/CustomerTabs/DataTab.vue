<template>
    {{ data.customer }}
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import { router} from '@inertiajs/vue3';//for sending requests;

let props = defineProps({
    modelValue: {
        type: Object,
        required: true
    }
});

let data = reactive({
    customer: props.modelValue
});

const emit = defineEmits(['update:modelValue']);
function handleChange(){
    emit('update:modelValue', 'putHereTheNewCustomerObject');
}



</script>

<style scoped>
</style>
