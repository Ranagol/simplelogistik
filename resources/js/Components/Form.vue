<script setup>
import { ref } from 'vue';
import InputField from "@/Components/Inputs/InputField.vue";
import CheckboxField from "@/Components/Inputs/CheckboxField.vue";
import SelectField from "@/Components/Inputs/SelectField.vue";
import SearchableField from "@/Components/Inputs/SearchableField.vue";
import TextAreaField from "@/Components/Inputs/TextAreaField.vue";
import AddressesEditor from '@/Components/Editors/AddressesEditor.vue';
import ParcelEditor from '@/Components/Editors/ParcelEditor.vue';

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
        <h2 v-if="section.title" class="mt-8 mb-3 font-bold text-[16px]">{{ $t(section.title) }}</h2>
        <div v-if="!section.sectionType || section.sectionType ==='default'" v-for="row, index in section.rows" :key="index" class="grid grid-flow-col" :class="row.className">
            <div v-for="field in row.fields" :key="field.name" :class="field.className">
                <InputField 
                    v-if="field.type === 'input'" 
                    :field="field" 
                    :store="store" 
                    :data="useData ? (field.subfield ? data[field.name] :  data) : {}" 
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
        <div v-if="section.sectionType === 'parcelEditor'">
            <ParcelEditor :fields="section.fields" :parent="content?.id" :store="store" :parcels="content[section.data]" />
        </div>
        <div v-if="section.sectionType === 'addressesEditor'">
            <AddressesEditor :fields="section.fields" :parent="content?.id" :store="store" :addresses="content[section.data]" />
        </div>
        <div v-if="section.sectionType === 'financialsEditor'">
            IN PROGRESS -> Finished Fr. 01.03.2024
        </div>
        <div v-if="section.sectionType === 'vehicleEditor'">
            IN PROGRESS -> Finished Fr. 01.03.2024
        </div>
    </section>
    
    <div class="grid justify-end pt-4 pb-2 mt-4 border-t place-items-center border-t-slate-200">
        <slot name="actions"></slot>
    </div>
</template>