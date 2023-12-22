<template>
    <div>
        <div class="flex justify-between mt-6">

            <!-- TITLE -->
            <Title 
                title="Parcels" 
            />

            <el-switch 
                v-model="data.showParcelData"
            />

        </div>

        <div v-if="data.showParcelData">

            <ParcelOverview
                v-model:cargoOrder="data.cargoOrder"
                :errors="props.errors"
                :mode="props.mode"
            />

            <ParcelTable
                :parcels="props.cargoOrder.parcels"
                :errors="props.errors"
                :mode="props.mode"
            />
        </div>
    </div>
</template>

<script setup>
import { defineProps, reactive } from 'vue';
import ParcelTable from './ParcelTable.vue';
import ParcelOverview from './ParcelOverview.vue';
import Title from '@/Shared/Title.vue';

const props = defineProps({
    cargoOrder: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
    mode: {
        type: String,
        required: true,
    },
});

const data = reactive({
    cargoOrder: props.cargoOrder,
    showParcelData: false,
});


</script>