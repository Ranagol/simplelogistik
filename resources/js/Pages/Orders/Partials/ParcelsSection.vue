<template>
    <h2 @click="onToggleSection(props.section.key)" class="w-full mb-4 text-lg font-bold text-gray-900 cursor-pointer dark:text-white"><span>{{ props.title }}</span> <el-icon class="transition-all duration-200" :class="{'rotate-180' : props.sectionActive}"><ArrowDown /></el-icon></h2>
    <section class="py-3 mb-4" :class="{'border-b': props.sectionActive}">
        <div class="grid" :class="{'hidden': !sectionActive}">
            <div class="grid grid-flow-row gap-4 mb-4" v-for="(parcel, index) in parcels" :key="index">
                <div class="grid grid-flow-col gap-4">
                    <div class="grid place-items-center"><span>{{ index + 1 }}</span></div>
                    <div class="min-w-[150px]">
                        <CustomDropdown 
                            :options="getPackageTypes()"
                            :floating="true"
                            labelText="labels.packing_type"
                            :updateValue="(value) => {parcels[index].type = value}"
                            :value="parcel?.type ?? 3"
                        /></div>
                    <div class=""><IconTooltipInput :keyup="e => {parcels[index].length = e.target.value; recalc() }" :value="parcel.length" placeholder="labels.length"/></div>
                    <div class=""><IconTooltipInput :keyup="e => {parcels[index].width = e.target.value; recalc() }" :value="parcel.width" placeholder="labels.width"/></div>
                    <div class=""><IconTooltipInput :keyup="e => {parcels[index].height = e.target.value; recalc() }" :value="parcel.height" placeholder="labels.height"/></div>
                    <div class=""><IconTooltipInput :keyup="e => {parcels[index].weight = e.target.value; recalc() }" :value="parcel.weight" placeholder="labels.weight"/></div>
                    <div class="grid place-items-center"><button @click.prevent="duplicatePackage(parcel)" class="grid p-2 text-white rounded-md bg-primary-700 place-items-center"><el-icon color="white" size="18"><CopyDocument /></el-icon></button></div>
                    <div class="grid place-items-center"><button @click.prevent="removePackage(index)" class="grid p-2 text-white bg-red-700 rounded-md place-items-center"><el-icon color="white" size="18"><Minus /></el-icon></button></div>
                </div>
            </div>
            <div class="grid justify-between grid-flow-col">
                <!-- <div class="grid grid-flow-col place-items-center">
                    <IconTooltipInput type="text" :keyup="setCount" :value="0" placeholder="labels.amount"/>
                    <button @click.prevent="addPackageByCount" class="relative grid grid-flow-col p-3 py-2 my-6 text-white rounded-md place-self-end bg-primary-700 place-items-center"><el-icon><Plus /></el-icon><span class="ps-2">{{ $t('labels.add-packages') }}</span></button>
                </div> -->
                <span></span>
                <button @click.prevent="addPackage" class="relative grid grid-flow-col p-3 py-2 my-6 text-white rounded-md place-self-end bg-primary-700 place-items-center"><el-icon><Plus /></el-icon><span class="ps-2">{{ $t('labels.add-package') }}</span></button>
            </div>
            <div class="grid grid-flow-col gap-4 my-5">
                <div class="grid grid-flow-col p-3 rounded-md bg-gray-50">
                    <div class="w-12">
                        <img src="/images/svg/packages.svg" class="w-12 object-fit">
                    </div>
                    <div class="w-full">
                        <p class="font-bold">{{ "Anzahl" }}</p>
                        <p>{{ calculated.packages }}</p>
                    </div>
                </div>
                <div class="grid grid-flow-col p-3 rounded-md bg-gray-50">
                    <div class="w-12">
                        <img src="/images/svg/weight.svg" class="w-12 object-fit">
                    </div>
                    <div class="w-full">
                        <p class="font-bold">{{ "Gewicht" }}</p>
                        <p>{{ calculated.weight }}</p>
                    </div>
                </div>
                <div class="grid grid-flow-col p-3 rounded-md bg-gray-50">
                    <div class="w-12">
                        <img src="/images/svg/area.svg" class="w-12 object-fit">
                    </div>
                    <div class="w-full">
                        <p class="font-bold">{{ "Fläche" }}</p>
                        <p>{{ (calculated.area / (100 * 100)).toFixed(2) /** Divided by 1 million */ }} m<sup>2</sup></p>
                    </div>
                </div>
                <div class="grid grid-flow-col p-3 rounded-md bg-gray-50">
                    <div class="w-12">
                        <img src="/images/svg/volume.svg" class="w-12 object-fit">
                    </div>
                    <div class="w-full">
                        <p class="font-bold">{{ "Volumen" }}</p>
                        <p>{{ (calculated.volume / (1000 * 1000)).toFixed(2) /** Divided by 1 million */ }} m<sup>3</sup></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script setup>
import IconTooltipInput from '@/Components/Inputs/IconTooltipInput.vue';
import CustomDropdown from '@/Components/Dropdowns/CustomDropdown.vue';
import { ArrowDown, CopyDocument, Minus, Plus, Remove } from '@element-plus/icons-vue';
import { initFlowbite } from 'flowbite';
import { reactive } from 'vue';
import { onMounted } from 'vue';
import { ref } from 'vue';

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
    width: '',
    type: 1
}

var reactable = reactive({
        count: 0
    });

const addPackageByCount = () => {
    recalc()
    for (let i = 0; i < reactable.count; i++) {
        parcels.push({...packageTemplate});
    }
}

const setCount = (e) => {
    reactable.count = e.target.value;
}

var parcels = reactive(props.data);

const addPackage = () => {
    recalc()
    parcels.push({...packageTemplate});
}

const duplicatePackage = (parcel) => {
    parcels.push({...parcel});
    recalc();
}

const getPackageTypes = () => {
    // TODO: Fetch package types from API
    return [
        {key: 1, name: 'Paket'},
        {key: 2, name: 'Sperrgut'},
        {key: 3, name: 'Europalette'},
        {key: 4, name: 'Einwegpalette'},
        {key: 5, name: 'Gitterbox'},
        {key: 6, name: 'Kiste'},
    ]
}


var calculated = reactive({
    packages: 0,
    volume: 0,
    weight: 0,
    area: 0
})


const removePackage = (index) => {
    parcels.splice(index, 1);
    if(parcels.length === 0) {
        addPackage();
    }
    recalc();
}

const calculatePackages = () => {
    calculated.packages = parcels.length
}

const calculateVolume = () => {
    calculated.volume =  (parcels.map(parcel => {
        return parcel.height * parcel.length * parcel.width;
    }).reduce((a, b) => a + b, 0)).toFixed(2);
}

const calculateArea = () => {
    calculated.area = (parcels.map(parcel => {
        return parcel.length * parcel.width;
    }).reduce((a, b) => a + b, 0)).toFixed(2);
}

const sumUpWeights = () => {
    var weight = 0;
    parcels.map(parcel => {
        weight += parseFloat(parcel.weight);
    });
    calculated.weight = weight.toFixed(2);
}

const recalc = () => {
    calculatePackages()
    calculateVolume()
    calculateArea()
    sumUpWeights()
}

const onToggleSection = (section) => {
    props.onToggleSection(section);
}

onMounted(() => {
    initFlowbite();
    recalc();
})

</script>
