
<template>
    <el-card class="box-card">
        <!-- HEADER -->
        <template #header>
            <div class="card-header grid grid-cols-8 gap-4">
                <span>#</span>
                <span>Packaging</span>
                <span>Order content</span>
                <span>Length cm</span>
                <span>Width cm</span>
                <span>Height cm</span>
                <span>Weight kg</span>
                <span>menu</span>
            </div>
        </template>

        <!-- LIST OF PARCELS -->
        

        <!-- FOOTER WITH SUMS -->
        <template #footer>Footer content</template>

    </el-card>
    
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import ParcelBase from './ParcelBase.vue';

let props = defineProps({
    parcels: {
        type: Array,
        required: true,
    },
});

let data = reactive({
    parcelsData: props.parcels,
});




</script>

<style scoped>
</style>
