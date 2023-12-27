
<template>
    <el-card class="box-card">
        <!-- HEADER -->
        <template #header>
            <div class="card-header flex flex-row ">
                <span>#</span>
                <span>Parcel type</span>
                <span>Order content</span>
                <span>Length cm</span>
                <span>Width cm</span>
                <span>Height cm</span>
                <span>Weight kg</span>
                <span>menu</span>
            </div>
        </template>

        <!-- LIST OF PARCELS -->
        <Parcel
            v-for="(parcel, index) in data.parcels"
            :key="index"
            :index="index"
            v-model:parcel="data.parcels[index]"
            :parcelTypes="props.selectOptions.parcelTypes"
            :errors="props.errors"
        />


        <!-- FOOTER WITH SUMS -->
        <template #footer>
            Footer content
        </template>

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
