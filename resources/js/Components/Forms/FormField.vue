<script setup>
import CustomDropdown from '@/Components/Dropdowns/CustomDropdown.vue';
import IconTooltipInput from '@/Components/Inputs/IconTooltipInput.vue';
import SearchableInput from '@/Components/Inputs/SearchableInput.vue';
import { reactive } from 'vue';

defineProps({
    fieldConfig: {
        type: Object,
        required: true
    }
})

var data = reactive({
    currentValue: ''
});

const updateValue = (value) => {
    data.currentValue = value;
}

</script>
<template>
    
    <IconTooltipInput 
        v-if="fieldConfig.type==='text'" 
        :class="fieldConfig.class" 
        :label="fieldConfig.label" 
        :placeholder="fieldConfig.placeholder ?? fieldConfig.label" />

    <CustomDropdown 
        v-else-if="fieldConfig.type==='dropdown' || fieldConfig.type==='select'" 
        :class="fieldConfig.class" 
        :config="fieldConfig" />
        
    <SearchableInput 
        v-if="fieldConfig.type==='searchable'" 
        :onUpdate="updateValue" 
        :onSelect="updateValue" 
        :value="data.currentValue.name" 
        :class="fieldConfig.class" 
        :config="fieldConfig" />

</template>