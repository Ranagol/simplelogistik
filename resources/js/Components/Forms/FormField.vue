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

        <div v-else-if="fieldConfig.type==='textarea'">
            <label for="textarea" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t(fieldConfig.label) }}</label>
            <textarea id="textarea" name="textarea" rows="3" class="block mt-1"></textarea>
        </div>

        <div v-else-if="fieldConfig.type==='checkbox' || fieldConfig.type==='check'">
            <div class="flex items-center">
                <input id="remember_me" name="remember_me" type="checkbox" class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500" />
                <label for="remember_me" class="block ml-2">{{ $t(fieldConfig.label) }}</label>
            </div>
        </div>
        <div v-else-if="fieldConfig.type==='separator'" class="h-6 col-span-12 py-6"></div>
    </div>
</template>