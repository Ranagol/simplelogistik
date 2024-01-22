<template>
    <tr  class="transition border-b cursor-pointer dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700"
        >
        <td class="w-4 px-4 py-3">
            <div class="flex items-center">
                <input :id="'checkbox-table-search-' + dataIndex" type="checkbox"

                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label :for="'checkbox-table-search-' + dataIndex" class="sr-only">checkbox</label>
            </div>
        </td>
        <td class="w-4 p-3">
                <el-icon :id="'table-column-header-' + dataIndex" :data-accordion-target="'#table-column-body-' + dataIndex"
        aria-expanded="false" :aria-controls="'table-column-body-' + dataIndex"><ArrowDown /></el-icon>
        </td>
        <td v-for="header, index in headers" :key="index" scope="row" 
            class="items-center px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ data[header.key] }}
        </td>
        <td>
            <button data-tooltip-placement="bottom" :data-tooltip-target="'tooltip-item-' + dataIndex" type="button" v-if="data.shipping_label_url">
                <el-icon size="26"><Download /></el-icon>
            </button>
            <button data-tooltip-placement="bottom" :data-tooltip-target="'tooltip-item-' + dataIndex" type="button" v-else>
                <el-icon size="26"><Close /></el-icon>
            </button>
            <Tooltip v-if="data.shipping_label_url" :tooltipText="$t('labels.download-shipping-label')" :id="dataIndex" />
            <Tooltip v-else :tooltipText="$t('labels.no-shipping-label')" :id="dataIndex" />
        </td>
    </tr>
    <tr  class="flex-1 hidden w-full overflow-x-auto" :id="'table-column-body-' + dataIndex"
        :aria-labelledby="'table-column-header-' + dataIndex">
        <td class="p-4 border-b dark:border-gray-700" colspan="9">
            <div class="grid grid-cols-4 gap-4 mb-4">
                <div v-for="address, key in data?.addresses" :key="key"
                    class="relative flex items-center justify-center h-32 p-2 bg-gray-100 rounded-lg sm:w-full sm:h-36 dark:bg-gray-700">
                    
                </div>
            </div>
            <div>
                <h6 class="mb-2 text-base font-bold leading-none text-gray-900 dark:text-white">
                    {{ $t('labels.parcel-details') }}</h6>
                <div class="max-w-screen-md text-base text-gray-500 dark:text-gray-400">
                    <p>
                        <strong class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">{{ $t('labels.delivery_info') }}</strong> {{ data.p_delivery_comments }}
                    </p>    
                    <p>    
                        <strong class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">{{ $t('labels.description_of_transport') }}</strong> {{ data.p_description_of_transport }}
                    </p>    
                </div>
            </div>
            <div class="grid grid-cols-4 gap-4 mt-4">
                <div
                    class="relative flex flex-col items-start justify-between p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.forwarder')}}</h6>
                    <div
                        class="bg-primary-100 text-primary-800 text-xs font-medium px-2.5 py-0.5 rounded-md dark:bg-primary-200 dark:text-primary-800 flex items-center">
                        {{ data.forwarder?.name ?? "Forwarder (missing)" }}
                    </div>
                </div>
                <div
                    class="relative flex flex-col justify-between p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.order_number')}}</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">
                        {{ data.p_order_number}}
                    </div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.payment_method')}}</h6>
                    <div class="flex items-center space-x-2">
                        {{ data.p_payment_method }}
                    </div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.purchase_price')}}</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">{{ data.purchase_price }} {{ data.currency }}</div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.customer_reference')}}</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">{{ data.customer_reference}}</div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.distance_duration')}}</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">{{ data.p_duration_minutes}}</div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.distance')}}</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">{{ data.p_distance_km}} km
                    </div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.selling_price')}}</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">{{ data.p_price_gross }} {{ data.currency }}</div>
                </div>
            </div>
            <div class="flex items-center mt-4 space-x-3">
                <button type="button"
                    class="flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    <el-icon>
                        <Edit />
                    </el-icon>
                    Bearbeiten
                </button>
                <button type="button"
                    class="flex items-center px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    <el-icon>
                        <View />
                    </el-icon> 
                    Details
                </button>
                <button type="button"
                    class="flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                    Stornieren
                </button>
            </div>
        </td>
    </tr>
</template>

<script setup>
import { ArrowDown, Close, CloseBold, DocumentRemove, Download } from '@element-plus/icons-vue';
import Tooltip from '../Tooltips/Tooltip.vue';

const props = defineProps({
    dataIndex: {
        type: Number,
        required: true
    },
    data: {
        type: Object,
        required: true
    },
    headers: {
        type: Array,
        required: true
    }
})

</script>


<style scoped>
    i.el-icon[aria-expanded=true]{
        background: transparent !important;
        transform: rotate(-180deg);
        transition: transform 200ms ease
    }

    i.el-icon[aria-expanded=false]{
        background: transparent !important;
        transform: rotate(0deg);
        transition: transform 200ms ease
    }

    .no-selection * {
        user-select: none !important;
        -moz-user-select: none !important;
        -webkit-user-select: none !important;
    }
    .no-selection input[type=checkbox] {
        user-select: auto !important;
        -moz-user-select: auto !important;
        -webkit-user-select: auto !important;
    }
</style>