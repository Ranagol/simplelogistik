<script setup>
import { CopyDocument, Delete } from '@element-plus/icons-vue';
import { onMounted, reactive, watch } from 'vue';
import OrderCalcHelper from "@/lib/OrderCalcHelper.js";
import BindableTextField from '../Inputs/BindableTextField.vue';
import { inputEmits } from 'element-plus';

let props = defineProps({
    parcels: {
        type: Array,
        required: false
    },
    store: {
        type: Object,
        required: false
    },
    parent: {
        type: Number,
        required: false
    },
    fields: {
        type: Object,
        required: false
    }
});

var state = reactive({
    parcels: props.parcels || [],
    calculations: {
        volume: 0, 
        area: 0, 
        weight: 0, 
        count: 0
    }
});



const duplicateParcel = (index) => {
    const item = state.parcels[index];
    const parcelTemplate = { 
        "id": null,
        "order_id": props.parent,
        "is_hazardous": item.is_hazardous,
        "information": item.information, 
        "name": item.name, 
        "height": item.height, 
        "length": item.length, 
        "width": item.width, 
        "weight": item.weight,
        "number": item.number, 
        "stackable": item.stackable, 
    }
    state.parcels.push(parcelTemplate); 
    state.calculations = OrderCalcHelper.calculate(state.parcels);
}

const deleteParcel = (index) => {
    state.parcels.splice(index, 1);
    state.calculations = OrderCalcHelper.calculate(state.parcels);
}

const addParcelSet = () => {
    const parcelTemplate = { 
        "id": null,
        "order_id": props.parent,
        "is_hazardous": false,
        "information": null, 
        "name": null, 
        "height": 0, 
        "length": 0, 
        "width": 0, 
        "weight": 0,
        "number": null, 
        "stackable": false, 
    }
    state.parcels.push(parcelTemplate); 
    state.calculations = OrderCalcHelper.calculate(state.parcels);
}

state.calculations = OrderCalcHelper.calculate(state.parcels);

defineEmits(['blur']);

</script>
<template>
    <div class="grid grid-flow-row gap-2">
        <div v-for="parcel, index in state.parcels" :key="index" class="grid grid-flow-col gap-2 p-2 rounded-md odd:bg-slate-100 hover:bg-slate-200">
            <div v-for="field in fields">
                <BindableTextField 
                    v-if="field.type === 'text'" 
                    :field="field"
                    :data="parcel"
                    :val="state.parcels[index][field.name]"
                    @focusin="e => e.target.select()"
                    @input="(event) => {
                        state.parcels[index][field.name] = event.target.value
                    }"
                    />
            </div>
            <div class="grid justify-end grid-flow-col gap-2 max-w-24 place-items-center">
                <button @click="duplicateParcel(index)" class="w-10 h-10 text-white transition-colors duration-200 rounded-md bg-primary-700 hover:bg-primary-500"><el-icon><CopyDocument/></el-icon></button>
                <button @click="deleteParcel(index)" class="w-10 h-10 text-white transition-colors duration-200 bg-red-700 rounded-md hover:bg-red-500"><el-icon><Delete/></el-icon></button>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <button @click="addParcelSet()" class="w-full p-2 text-white transition-colors duration-200 rounded-md bg-primary-700 hover:bg-primary-500">Add Parcel</button>
    </div>
    <div class="grid grid-flow-col gap-4 mt-6">
        <div class="grid grid-flow-col gap-4 p-4 rounded-md bg-slate-200">
            <div class="grid w-16 h-16 rounded-md bg-slate-300 place-items-center">
                <img src="/images/svg/packages.svg" alt="Parcel Icon" class="w-12 h-12" />
            </div>
            <div class="">
                <p>{{ $t("pages.orders.form.sections.parcel_summary.total_parcels") }}</p>
                <span class="font-bold text-[18px]">{{ parseInt(state.calculations.count) }}</span>
            </div>
        </div>
        <div class="grid grid-flow-col gap-4 p-4 rounded-md bg-slate-200">
            <div class="grid w-16 h-16 rounded-md bg-slate-300 place-items-center">
                <img src="/images/svg/volume.svg" alt="Parcel Icon" class="w-12 h-12" />
            </div>
            <div class="">
                <p>{{ $t("pages.orders.form.sections.parcel_summary.total_volume") }}</p>
                <span class="font-bold text-[18px]">{{ parseFloat(state.calculations.volume / (100*100*100)).toFixed(2) }} m<sup>3</sup></span>
            </div>
        </div>
        <div class="grid grid-flow-col gap-4 p-4 rounded-md bg-slate-200">
            <div class="grid w-16 h-16 rounded-md bg-slate-300 place-items-center">
                <img src="/images/svg/area.svg" alt="Parcel Icon" class="w-12 h-12" />
            </div>
            <div class="">
                <p>{{ $t("pages.orders.form.sections.parcel_summary.total_area") }}</p>
                <span class="font-bold text-[18px]">{{ parseFloat(state.calculations.area / (100*100)).toFixed(2) }} m<sup>2</sup></span>
            </div>
        </div>
        <div class="grid grid-flow-col gap-4 p-4 rounded-md bg-slate-200">
            <div class="grid w-16 h-16 rounded-md bg-slate-300 place-items-center">
                <img src="/images/svg/weight.svg" alt="Parcel Icon" class="w-12 h-12" />
            </div>
            <div class="">
                <p>{{ $t("pages.orders.form.sections.parcel_summary.total_weight") }}</p>
                <span class="font-bold text-[18px]">{{ parseFloat(state.calculations.weight).toFixed(2) }} kg</span>
            </div>
        </div>
    </div>
</template>