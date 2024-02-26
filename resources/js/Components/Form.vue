<script setup>
import { ref } from 'vue';
import InputField from "@/Components/Inputs/InputField.vue";
import CheckboxField from "@/Components/Inputs/CheckboxField.vue";
import SelectField from "@/Components/Inputs/SelectField.vue";
import SearchableField from "@/Components/Inputs/SearchableField.vue";
import TextAreaField from "@/Components/Inputs/TextAreaField.vue";

var props = defineProps({
    form: {
        type: Object,
        required: true
    }, 
    useData: {
        type: Boolean,
        required: false
    },
    store: {
        type: Object,
        required: false
    },
    content: Object,
});


const data = ref(props.useData ? props.content : {});

</script>
<template>
    <section v-for="section in form.sections" class="grid col-span-12 gap-4">
        <h2 v-if="section.title" class="my-4">{{ $t(section.title) }}</h2>
        <div class="grid grid-cols-12 gap-4">
            <div v-for="field, index in section.fields" :key="index" :class="field?.size ?? 'col-span-6'">
                <InputField 
                    v-if="field.type === 'input'" 
                    :field="field" 
                    :store="store" 
                    :data="useData ? data : {}" 
                    />
                    
                <CheckboxField 
                    v-else-if="field.type === 'check'" 
                    :field="field" 
                    :store="store" 
                    :data="useData ? data : {}" 
                    />
                    
                <SelectField 
                    v-else-if="field.type === 'select'" 
                    :field="field" 
                    :store="store" 
                    :data="useData ? data : {}" 
                    />
                    
                <SearchableField 
                    v-else-if="field.type === 'search'" 
                    :field="field" 
                    :store="store" 
                    :data="useData ? data : {}" 
                    />
                    
                <TextAreaField 
                    v-else-if="field.type === 'text'" 
                    :field="field" 
                    :store="store" 
                    :data="useData ? data : {}" 
                    />
                    
            </div>
        </div>
    </section>
    <div class="grid justify-end pt-4 pb-2 mt-4 border-t place-items-center border-t-slate-200">
        <slot name="actions"></slot>
    </div>
</template>