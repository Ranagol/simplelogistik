
<template>
    <el-card class="box-card">
        <!-- HEADER -->
        <template #header>
            <div class="card-header flex flex-row">
                <span class="w-8">#</span>
                <span class="w-1/6 pl-2">Parcel type</span>
                <span class="w-1/3 pl-2">Order content</span>
                <span class="w-1/12 pl-2">Length cm</span>
                <span class="w-1/12 pl-2">Width cm</span>
                <span class="w-1/12 pl-2">Height cm</span>
                <span class="w-1/12 pl-2">Weight kg</span>
                <span class="pl-2">menu</span>
            </div>
        </template>

        <!-- LIST OF PARCELS -->
        <div>
            <Parcel
                v-for="(parcel, index) in data.parcels"
                :key="index"
                :index="index"
                v-model:parcel="data.parcels[index]"
                :parcelTypes="props.selectOptions.parcelTypes"
                :errors="props.errors"
            />
        </div>

    </el-card>
    
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import Parcel from './Parcel.vue';

let props = defineProps({
    parcels: {
        type: Array,
        required: true,
    },
    selectOptions: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
});

let data = reactive({
    parcels: props.parcels,
});




</script>

<style scoped>
</style>
