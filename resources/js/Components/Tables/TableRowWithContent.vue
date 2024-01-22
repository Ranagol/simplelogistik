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
        <td v-if="actions !== undefined && actions !== ''"
                                    class="flex items-center justify-end px-4 py-3">
            <button :id="'actions-dropdown-button-' + entry.id"
                :data-dropdown-toggle="'actions-dropdown-' + entry.id"
                class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                type="button">
                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                </svg>
            </button>
            <div :id="'actions-dropdown-' + entry.id"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                    :aria-labelledby="'actions-dropdown-button-' + entry.id">
                    <li v-for=" action  in  actions ">
                        <button @click="handleShow(entry.id)" v-if="action === 'show'" href="#"
                            class="block w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{
                                $t('labels.show') }}</button>
                        <button @click="handleEdit(entry.id)" v-else-if="action === 'edit'" href="#"
                            class="block w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{
                                $t('labels.edit') }}</button>
                        <button @click="handleDelete(entry.id)" v-if="action === 'delete'" href="#"
                            class="block w-full px-4 py-2 text-left text-red-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-red-700">{{
                                $t('labels.delete') }}</button>
                    </li>
                </ul>
            </div>
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
                        <strong class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">{{ $t('labels.delivery_info') }}</strong> {{ data.delivery_comments }}
                    </p>    
                    <p>    
                        <strong class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">{{ $t('labels.description_of_transport') }}</strong> {{ data.description_of_transport }}
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
                        {{ data.order_number}}
                    </div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.payment_method')}}</h6>
                    <div class="flex items-center space-x-2">
                        {{ data.payment_method }}
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
                        {{ $t('labels.customer_id')}}</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">{{ data.customer_id}}</div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.distance_duration')}}</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">{{ data.duration_minutes}}</div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.distance')}}</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">{{ data.distance_km}} km
                    </div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.selling_price')}}</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">{{ data.price_gross }} {{ data.currency }}</div>
                </div>
            </div>
            <div class="flex items-center mt-4 space-x-3">
                <div class="grid grid-flow-col gap-2 align-middle place-items-center">
                    <button type="button"
                    class="flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        <el-icon>
                            <Edit />
                        </el-icon>
                    <span class="pl-2">Bearbeiten</span>
                    </button>
                    <button type="button"
                    class="flex items-center px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        <el-icon>
                            <View />
                        </el-icon> 
                    <span class="pl-2">Details</span>
                    </button>
                    <button type="button"
                    class="flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                    <el-icon>
                        <Close />
                    </el-icon> 
                    <span v-if="data.canceled">Storniert</span>
                    <span v-else class="pl-2">Stornieren</span>
                    </button>
                </div>
            </div>
        </td>
    </tr>
</template>

<script setup>
import { ArrowDown, Close, CloseBold, DocumentRemove, Download, View, Edit } from '@element-plus/icons-vue';
import Tooltip from '../Tooltips/Tooltip.vue';

const props = defineProps({
    dataIndex: {
        type: Number,
        required: true
    },
    actions: {
        type: Array,
        required: false
    }, 
    data: {
        type: Object,
        required: true
    },
    headers: {
        type: Array,
        required: true
    },
    handleShow: {
        type: Function
    },
    handleEdit: {
        type: Function
    },
    handleDelete: {
        type: Function
    },
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