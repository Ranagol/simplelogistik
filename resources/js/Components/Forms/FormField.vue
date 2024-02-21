<script setup>
import CustomDropdown from '@/Components/Dropdowns/CustomDropdown.vue';
import IconTooltipInput from '@/Components/Inputs/IconTooltipInput.vue';
import SearchableInput from '@/Components/Inputs/SearchableInput.vue';
import { reactive } from 'vue';

const props = defineProps({
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

var className = props.fieldConfig.class;

</script>
<template>
    <div :class="className ?? 'col-span-6'">
        <IconTooltipInput 
            v-if="fieldConfig.type==='text'" 
            :label="fieldConfig.label" 
            :placeholder="fieldConfig.placeholder ?? fieldConfig.label" />

        <CustomDropdown 
            v-else-if="fieldConfig.type==='dropdown' || fieldConfig.type==='select'" 
            :config="fieldConfig" />
            
        <SearchableInput 
            v-else-if="fieldConfig.type==='searchable'" 
            :onUpdate="updateValue" 
            :onSelect="updateValue" 
            :value="data.currentValue.name" 
            :config="fieldConfig" />

        <div v-else class="text-red-400">Invalid Field Configuration</div>
    </div>
</template>