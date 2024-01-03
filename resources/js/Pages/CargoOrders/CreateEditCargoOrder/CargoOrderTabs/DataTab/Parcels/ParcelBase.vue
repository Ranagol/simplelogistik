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

            <!-- THIS WORKS, BUT IT IS NOT NEEDED... -->
            <!-- <SomeOrderData
                v-model:order="data.order"
                :errors="props.errors"
                :mode="props.mode"
            /> -->
            
            <!-- DISPLAYS ALL PARCELS-->
            <ListOfParcels
                :parcels="props.order.parcels"
                :errors="props.errors"
                :mode="props.mode"
                :selectOptions="props.selectOptions"
            />

            <SumBase
                :parcels="props.order.parcels"
            />
            

        </div>
    </div>
</template>

<script setup>
import { defineProps, reactive } from 'vue';
import ParcelTable from './ParcelTable.vue';
import SomeOrderData from './SomeOrderData.vue';
import Title from '@/Shared/Title.vue';
import _ from 'lodash';
import SumBase from './SumBase.vue';
import ListOfParcels from './ListOfParcels.vue';

const props = defineProps({
    order: {
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
    selectOptions: {
        type: Object,
        required: true,
    },
});

const data = reactive({
    order: props.order,
    showParcelData: false,
});


</script>