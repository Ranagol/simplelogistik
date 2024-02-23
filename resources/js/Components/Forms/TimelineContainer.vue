<script setup>
import PageActions from '../Page/PageActions.vue';
import FormField from './FormField.vue';

defineProps({
    config: {
        type: Object,
        required: true
    },
    modeEdit: {
        type: Boolean,
        required: false,
    }
});


</script>
<template>
    
    <FormField v-for="field in config.fields" :fieldConfig="field" />
</template>