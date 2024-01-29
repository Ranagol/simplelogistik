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
                <el-icon :id="'table-column-header-' + dataIndex" 
                    :data-accordion-target="'#table-column-body-' + dataIndex" 
                    aria-expanded="false" 
                    :aria-controls="'table-column-body-' + dataIndex">
                    <ArrowDown />
                </el-icon>
        </td>
        <ConditionalBodyColumn v-for="header in headers" :key="header.key" :data="header" :cellData="data[header.key]" />
        <td v-if="actions !== undefined && actions !== ''"
                                    class="flex items-center justify-end px-4 py-3">
            <button :id="'actions-dropdown-button-' + dataIndex"
                :data-dropdown-toggle="'actions-dropdown-' + dataIndex"
                class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                type="button">
                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                </svg>
            </button>
            <div :id="'actions-dropdown-' + dataIndex"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                    :aria-labelledby="'actions-dropdown-button-' + dataIndex">
                    <li v-for="action in actions">
                        <a :href="route('orders.show', data.id)" v-if="action === 'show'"
                            class="block w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{
                                $t('labels.show') }}</a>
                        <a :href="route('orders.edit', data.id)" v-else-if="action === 'edit'"
                            class="block w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{
                                $t('labels.edit') }}</a>                        
                    </li>
                </ul>
            </div>
        </td>
    </tr>
    <tr  class="flex-1 hidden w-full overflow-x-auto" :id="'table-column-body-' + dataIndex"
        :aria-labelledby="'table-column-header-' + dataIndex">
        <td class="p-4 border-b dark:border-gray-700" :colspan="headers.length + 3">
            <div class="grid grid-cols-4 gap-4 mb-4">
                <!-- TODO: (Andor) Require Customer Address as Address Object  -->
                <div
                    class="relative grid p-2 py-6 bg-gray-100 rounded-lg place-items-center sm:w-full dark:bg-gray-700">
                    <p class="w-full px-3 pt-5">
                        <span v-if="data.customer.company_name">{{ data.customer.company_name }}</span>
                    </p>
                    <p class="w-full px-3">
                        <span>{{ data.customer.first_name }} {{ data.customer.last_name }}</span>
                    </p>
                    <p class="w-full px-3">
                        <span>{{ data.customer.street }} {{ data.customer.house_number }}</span>
                    </p>
                    <p class="w-full px-3">
                        <span>{{ data.customer.zip_code }} {{ data.customer.city }}</span>
                    </p>
                    <p class="w-full px-3 pt-2">
                        <span>{{ data.customer.state }} {{ data.customer.country }}</span>
                    </p>
                </div>
                <div v-for="address, key in data?.addresses" :key="key"
                    class="relative grid p-2 py-6 bg-gray-100 rounded-lg place-items-center sm:w-full dark:bg-gray-700">
                    <p class="absolute top-0 right-0 pb-2 m-3">
                        <span v-if="address.address_type === 'Pickup address'" class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">{{ address.address_type }}</span>
                        <span v-else class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">{{ address.address_type }}</span>
                    </p>
                    <p class="w-full px-3 pt-5">
                        <span v-if="address.company_name">{{ address.company_name }}</span>
                        
                    </p>
                    <p class="w-full px-3">
                        <span>{{ address.first_name }} {{ address.last_name }}</span>
                    </p>
                    <p class="w-full px-3">
                        <span>{{ address.street }} {{ address.house_number }}</span>
                    </p>
                    <p class="w-full px-3">
                        <span>{{ address.zip_code }} {{ address.city }}</span>
                    </p>
                    <p class="w-full px-3 pt-2">
                        <span>{{ address.state }} {{ address.country.country_name }}</span>
                    </p>
                    <p class="w-full px-3">
                        <span>{{ address.country.country_name }}</span>
                    </p>
                </div>
            </div>
            
            <hr class="my-4"/>
            <div class="grid grid-cols-1 mt-4">
                <div
                    class="relative flex flex-col items-start justify-between p-3 pt-0">
                    <span
                        class="mb-4 text-lg font-medium leading-none text-gray-600 dark:text-white">
                        {{ $t('labels.package-information')}}</span>
                    <div class="grid grid-flow-row gap-3">
                        <div
                            class="">
                            <p class="text-[16px]">{{ $t('labels.package-count-total') }} <span class="bg-primary-100 text-corporate-800 text-[1rem] font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-primary-900 dark:text-corporate-300">{{ data.parcels?.length ?? 0 }}</span></p>
                        </div>
                        <div
                            class="">
                            <!-- TODO: Replace Fake avatar with real Forwarder Logo -->
                            <p class="grid grid-flow-col text-[16px] place-items-center justify-start">{{ $t('labels.forwarder') }} 
                                <img :src="'https://i.pravatar.cc/80?img=' + data.forwarder.id" class="object-cover w-16 h-8 ml-2" />
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-4 gap-4 mt-4">
                <div v-for="parcel, index in data.parcels"
                    class="relative grid grid-flow-row p-3 rounded-lg shadow-md dark:transparent">
                    <span
                        class="mb-2 text-base font-medium leading-none text-gray-500 dark:text-white">
                        <!-- Dynamic String with replacement -->
                        {{ $t('labels.package-with-index', {index: (index + 1)})}}</span>
                        <div
                        class="absolute top-0 right-0 mt-3 mr-2 bg-blue-100 text-primary-800 text-xs font-medium px-2.5 py-0.5 rounded-md dark:bg-blue-200 dark:text-blue-800 flex items-center">
                        <span class="text-[12px]">{{ parcel.name }}</span>
                    </div>
                    <div class="grid grid-flow-col">
                        <div
                        class="grid grid-flow-row gap-2 mt-2 text-xs font-medium">
                            <p class="text-[12px] rounded-md"><span class="block w-full font-bold">{{ $t('labels.sizes-unit') }}</span> {{ parcel.length }} x {{ parcel.width }} x {{ parcel.height }} </p>
                            <p class="text-[12px]"><span class="block w-full">{{ $t('labels.weight') }}</span> {{ parcel.weight }}kg </p>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-4"/>
            <div class="grid grid-cols-4 gap-4 mt-4">
                <div
                    class="relative flex flex-col items-start justify-between p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.forwarder')}}</h6>
                    <div
                        class="bg-blue-100 text-primary-800 text-xs font-medium px-2.5 py-0.5 rounded-md dark:bg-blue-200 dark:text-blue-800 flex items-center">
                        <el-icon size="18"><Van /></el-icon>
                        <span class="text-[12px] pl-2">{{ data.forwarder?.name ?? "Forwarder (missing)" }}</span>
                    </div>
                </div>
                <div
                    class="relative flex flex-col justify-between p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.order_number')}}</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">
                        {{ data.id}}
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
                    <div class="flex items-center text-gray-500 dark:text-gray-400">{{ data?.customer?.id ?? "Kein Kunde"}}</div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.distance_duration')}}</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">{{ data.details?.duration_minutes ?? '' }} min</div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.distance')}}</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">{{ data.details?.distance_km ?? '' }} km
                    </div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6
                        class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">
                        {{ $t('labels.selling_price')}}</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">{{ data.details?.price_gross ?? '' }} {{ data.currency }}</div>
                </div>
            </div>
            <div class="flex items-center justify-between mt-4 space-x-3">
                <div class="grid grid-flow-col gap-2 align-middle place-items-center">
                    <button type="button"
                    class="flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        <el-icon size="18">
                            <Edit />
                        </el-icon>
                    <span class="pl-2">{{ $t('labels.edit') }}</span>
                    </button>
                    <button type="button"
                    class="flex items-center px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        <el-icon size="18">
                            <View />
                        </el-icon> 
                    <span class="pl-2">{{ $t('labels.details') }}</span>
                    </button>
                    <button type="button"
                    class="flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                        <el-icon size="18">
                            <Close />
                        </el-icon> 
                        <span v-if="data.canceled">{{ $t('labels.cancelled') }}</span>
                        <span v-else class="pl-2">{{ $t('labels.void') }}</span>
                    </button>
                </div>
                <div class="grid grid-flow-col">
                    <button type="button"
                    class="flex items-center px-3 py-2 text-sm font-medium text-center text-gray-800 rounded-lg hover:bg-gray-200 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-900">
                        <el-icon size="18" v-if="data.shipping_label_pdf">
                            <Download />
                        </el-icon>
                        <el-icon size="18" v-else>
                            <DocumentRemove />
                        </el-icon> 
                        <span class="pl-2" v-if="data.shipping_label_pdf">{{ $t('labels.download-shipping-label') }}</span>
                        <span class="pl-2" v-else>{{ $t('labels.no-shipping-label') }}</span>
                    </button>
                    <button type="button" :id="'multilingualDownloadDropdownButton-' + data.id" :data-dropdown-toggle="'multilingualDownloadDropdown-' + data.id" 
                    class="flex items-center px-3 py-2 text-sm font-medium text-center text-gray-800 rounded-lg hover:bg-gray-200 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-900">
                        <el-icon size="18" v-if="data.details?.order_pdf ?? '' ">
                            <Message />
                        </el-icon>
                        <el-icon size="18" v-else>
                            <DocumentRemove />
                        </el-icon> 
                        <span class="pl-2" >{{ $t('labels.send-order') }}</span>
                    </button>
                    <div :id="'multilingualDownloadDropdown-' + data.id" class="z-10 hidden divide-y rounded-lg shadow-lg bg-primary-800 divide-primary-100 w-44 dark:bg-primary-400">
                        <ul class="py-2 text-sm dark:text-corporate-700 text-corporate-200" :aria-labelledby="'multilingualDownloadDropdownButton' + data.id">
                            
                            <li>
                                <span class="p-3 font-semibold text-corporate-100">Herunterladen in:</span>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-corporate-200 hover:bg-primary-500 dark:hover:bg-primary-600 dark:hover:text-white"><img src="/images/flags/de.svg" class="inline-flex w-5 h-5 object-fit"> <span class="pl-2">In Deutsch</span></a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-corporate-200 hover:bg-primary-500 dark:hover:bg-primary-600 dark:hover:text-white"><img src="/images/flags/en.svg" class="inline-flex w-5 h-5 object-fit"> <span class="pl-2">In Englisch</span></a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-corporate-200 hover:bg-primary-500 dark:hover:bg-primary-600 dark:hover:text-white"><img src="/images/flags/bg.svg" class="inline-flex w-5 h-5 object-fit"> <span class="pl-2">In Bulgarisch</span></a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-corporate-200 hover:bg-primary-500 dark:hover:bg-primary-600 dark:hover:text-white"><img src="/images/flags/pl.svg" class="inline-flex w-5 h-5 object-fit"> <span class="pl-2">In Polnisch</span></a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-corporate-200 hover:bg-primary-500 dark:hover:bg-primary-600 dark:hover:text-white"><img src="/images/flags/ro.svg" class="inline-flex w-5 h-5 object-fit"> <span class="pl-2">In Rumänisch</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</template>

<script setup>
import { ArrowDown, Close, DocumentRemove, Download, View, Edit, Van, Box, Message } from '@element-plus/icons-vue';
import MultilingualDownloadModal from '@Components/Modal/MultilingualDownloadModal.vue';
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';
import ConditionalBodyColumn from './ConditionalBodyColumn.vue';

onMounted(()=> {
    initFlowbite()
})

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