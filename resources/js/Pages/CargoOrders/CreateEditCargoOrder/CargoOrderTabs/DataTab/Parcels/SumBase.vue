
<template>
    
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import { router} from '@inertiajs/vue3';//for sending requests;
import _ from 'lodash';
import { useForm } from '@inertiajs/vue3';


let props = defineProps({
    
});

let data = reactive({
  
});

const emit = defineEmits(['hideModal']);

let computedExample = computed(
    () => {
  	return 'random text by computed';
    }
);

watch(
    () => data, 
    (newValue, oldValue) => {
        console.log('count changed');
        console.log('oldValue:', oldValue)
        console.log('newValue:', newValue)
    },
    { deep: true }
);

//Emitting example
function hideModal() {
    emit('hideModal');
}

onMounted(() => {
  console.log('onMounted.')
});

</script>

<style scoped>
</style>
