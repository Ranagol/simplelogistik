<script setup>
import TableCell from "@/Components/Tables/TableCell.vue"
import { ArrowDown, CloseBold, Star, StarFilled, View } from "@element-plus/icons-vue";
import { ref, watch } from "vue";
import OrderAddressBox from "@/Components/Boxes/OrderAddressBox.vue";
import OrderParcelBox from "@/Components/Boxes/OrderParcelBox.vue";
import OrderDetailBox from "@/Components/Boxes/OrderDetailBox.vue";
import { store as useStore } from "@/Stores/dashboardStore";
const dashboardStore = useStore();
var orders = dashboardStore.getOrders();

const props = defineProps({
    content: {
        type: Object,
        required: true
    },
    cellConfig: {
        type: Object,
        required: true
    },
    contentSettings: {
        type: Object,
        required: true
    },
    row: {
        type: Number,
        required: true
    }
})

var colspan = 2
props.cellConfig.map((cell) => {
    cell.show ? colspan++ : null
})

var _dd_ID = Math.random().toString(36).slice(2, 12);

const placeOnDashboard = (item) => {
    try{
        if(dashboardStore.find(item) === undefined){
            dashboardStore.addOrderToWatchList(item);
        } else {
            dashboardStore.remove(item);
        }
    } catch(error){
        console.error(error);
    }
}



var isWatched = (item) => {
    return dashboardStore.find(item) !== undefined
}

</script>
<template>
    <tr class="transition border-b dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700" >
        <td class="w-4">
            <div class="grid p-3 bg-transparent cursor-pointer place-items-center"
            :id="'table-column-header-' + row" 
            :data-accordion-target="'#table-column-body-' + row" 
            aria-expanded="false" 
            :aria-controls="'table-column-body-' + row">
                <el-icon size="18"><ArrowDown /></el-icon>
            </div>
        </td>
        <td>
            <div class="grid p-3 bg-transparent place-items-center">
                <span class="cursor-pointer" @click="() => placeOnDashboard(content)">
                    <el-icon v-if="isWatched(content)" size="20" color="#215e7d"><StarFilled /></el-icon>
                    <el-icon v-else size="20" color="#215e7d"><Star /></el-icon>
                </span>
            </div>
        </td>
        <TableCell v-for="cell, ci in cellConfig" :cellConfig="cell" :content="content" :key="ci" class="p-3"/>
    </tr>
    <tr  class="flex-1 hidden w-full overflow-x-auto" 
        :id="'table-column-body-' + row" 
        :aria-labelledby="'table-column-header-' + row">
        <td class="p-4 border-b dark:border-gray-700" :colspan="colspan">
            <div v-for="section,index in contentSettings.rows" :key="index" class="grid grid-cols-4 gap-4 pb-4 mb-4 border-b last:border-none border-b-slate-200">
                <div class="grid col-span-4 font-bold text-[16px]" v-if="section.sectionTitle">
                    {{ $t(section.sectionTitle) }}
                </div>
                <OrderAddressBox 
                    v-if="section.type === 'addressBox'" 
                    v-for="address,index in content.addresses" 
                    :key="index" 
                    :content="address" 
                    :loadFields="section.show.fields" />
                <OrderParcelBox 
                    v-if="section.type === 'parcelsBox'" 
                    v-for="parcel,index in content.parcels" 
                    :key="index" 
                    :parcelType="content.type_of_transport"
                    :content="parcel" 
                    :loadFields="section.show.fields" />
                <OrderDetailBox 
                    v-if="section.type === 'detailsBox'" 
                    v-for="field,index in section.show.fields"
                    :key="index"
                    :content="content" 
                    :field="field" />
            </div>
            <div class="grid justify-between grid-flow-col">
                <!-- Buttons -->
                <div class="grid justify-start grid-flow-col gap-4">
                    <button class="grid justify-start grid-flow-col gap-2 p-3 px-4 text-white rounded-md place-items-center bg-primary-700 hover:bg-primary-500"><el-icon size="18"><View /></el-icon>{{ $t("buttons.general.edit") }}</button>
                    <button class="grid justify-start grid-flow-col gap-2 p-3 px-4 text-white bg-red-700 rounded-md place-items-center hover:bg-red-500"><el-icon size="18"><CloseBold /></el-icon>{{ $t("buttons.general.void") }}</button>
                </div>
                <!-- Action Dropdowns -->
                <div class="grid grid-flow-col gap-4 place-items-center">
                    <div>{{  $t('labels.general.download_label') }}</div>
                    <div class="relative z-50">
                        <button :id="_dd_ID + '--file-download-dropdown-button'" class="" :data-dropdown-toggle="_dd_ID + '-file-download-dropdown'">
                            {{  $t('labels.general.download_transport_details') }}
                        </button>
                        <div role="dropdown" class="hidden bg-white border rounded-md overflow-clip" :id="_dd_ID + '-file-download-dropdown'">
                            <div class="w-full p-2 px-4 whitespace-nowrap hover:text-white hover:bg-primary-700">{{ $t('labels.general.download_in') }} {{ $t('lang.de') }}</div>
                            <div class="w-full p-2 px-4 whitespace-nowrap hover:text-white hover:bg-primary-700">{{ $t('labels.general.download_in') }} {{ $t('lang.en') }}</div>
                            <div class="w-full p-2 px-4 whitespace-nowrap hover:text-white hover:bg-primary-700">{{ $t('labels.general.download_in') }} {{ $t('lang.pl') }}</div>
                            <div class="w-full p-2 px-4 whitespace-nowrap hover:text-white hover:bg-primary-700">{{ $t('labels.general.download_in') }} {{ $t('lang.ro') }}</div>
                            <div class="w-full p-2 px-4 whitespace-nowrap hover:text-white hover:bg-primary-700">{{ $t('labels.general.download_in') }} {{ $t('lang.bg') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</template>

<style scoped>
    [aria-expanded="false"] {
        transform: rotate(0deg);
        transition: transform 0.3s;
    }
    [aria-expanded="true"] {
        transform: rotate(180deg);
        transition: transform 0.3s;
    }
</style>