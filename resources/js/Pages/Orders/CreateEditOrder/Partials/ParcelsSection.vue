<template>
    <h2 @click="onToggleSection(props.section.key)" class="w-full mb-4 text-lg font-bold text-gray-900 cursor-pointer dark:text-white"><span>{{ props.title }}</span> <el-icon class="transition-all duration-200" :class="{'rotate-180' : props.sectionActive}"><ArrowDown /></el-icon></h2>
    <section class="py-3 mb-4" :class="{'border-b': props.sectionActive}">
        <div class="grid" :class="{'hidden': !sectionActive}">
            <button @click.prevent="addPackage" class="relative grid grid-flow-col p-3 py-2 mb-6 text-white rounded-md place-self-end bg-primary-700 place-items-center"><el-icon><Plus /></el-icon><span class="ps-2">{{ $t('labels.add-package') }}</span></button>
            <div class="grid grid-flow-row gap-4 mb-4" v-for="(parcel, index) in parcels" :key="index">
                <div class="grid grid-flow-col gap-4">
                    <div class="grid place-items-center"><span>{{ index + 1 }}</span></div>
                    <div class=""><IconTooltipInput :value="parcel.weight" placeholder="labels.weight"/></div>
                    <div class=""><IconTooltipInput :value="parcel.height" placeholder="labels.height"/></div>
                    <div class=""><IconTooltipInput :value="parcel.length" placeholder="labels.length"/></div>
                    <div class=""><IconTooltipInput :value="parcel.width" placeholder="labels.width"/></div>
                    <div class="grid place-items-center"><button @click.prevent="removePackage(index)" class="text-red-500"><el-icon size="18"><Minus /></el-icon></button></div>
                </div>
            </div>
        </div>
    </section>
</template>
<script setup>
import IconTooltipInput from '@/Components/Inputs/IconTooltipInput.vue';
import { ArrowDown, Minus, Plus, Remove } from '@element-plus/icons-vue';
import { initFlowbite } from 'flowbite';
import { reactive } from 'vue';
import { onMounted } from 'vue';

const props = defineProps({
    data: {
        type: Array,
        required: true
    },
    onToggleSection: {
        type: Function,
        required: true
    },
    section: {
        type: Object,
        required: true
    },
    sectionActive: {
        type: Boolean,
        required: true
    },
    title: {
        type: String,
        required: true
    }
})

var packageTemplate = {
    weight: '',
    height: '',
    length: '',
    width: ''
}

var parcels = reactive(props.data);

const addPackage = () => {
    parcels.push({...packageTemplate});
}

const removePackage = (index) => {
    parcels.splice(index, 1);
    if(parcels.length === 0) {
        addPackage();
    }
}

const onToggleSection = (section) => {
    props.onToggleSection(section);
}

onMounted(() => {
    initFlowbite();
})

</script>
