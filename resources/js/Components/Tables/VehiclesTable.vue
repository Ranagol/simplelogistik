<template>
    <section class="bg-gray-50 dark:bg-gray-900">
            <!-- Start coding here -->
            <div class="relative bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                <div
                    class="grid items-center justify-between grid-flow-col p-4 space-y-3 border-b md:flex-row md:space-y-0 md:space-x-4 dark:border-gray-700">
                    
                    <FilteredSearch searchAt="vehicles.index" :headers="_headers" />

                    <div class="grid grid-flow-col gap-4">
                        <!-- CREATE ORDER BUTTON -->
                        <button type="button"
                            class="flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-white rounded-lg md:w-auto bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <el-icon class="me-2">
                                <Plus />
                            </el-icon>
                            {{ $t('page-actions.vehicle-create') }}
                        </button>
                        <!-- SELECT Visible Table Columns -->
                        <button id="showTableColumnsButton" data-dropdown-toggle="showTableColumns"
                            class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                            type="button">
                            <el-icon><View /></el-icon>
                            <!-- {{ $t('labels.limit-search') }} -->
                            <el-icon size="24" class="pl-2"><ArrowDown /></el-icon>
                        </button>
                        <div id="showTableColumns"
                            class="hidden w-auto p-3 bg-white border border-gray-100 rounded-lg shadow-lg dark:bg-gray-700">
                            <!-- class="hidden w-auto p-3 overflow-y-scroll bg-white border border-gray-100 rounded-lg shadow-lg max-h-48 dark:bg-gray-700"> -->
                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">{{ $t('labels.select-fields')}}</h6>
                            <ul class="space-y-2 text-sm" aria-labelledby="showTableColumnsButton">
                                <li v-for="head in _headers" class="flex items-center">
                                    <input @change="(e) => updateListedItems(head.key, e.currentTarget.checked)" :id="'display-columns-label-' + head.key" type="checkbox"
                                        :value="head.key" :checked="head.show === true"
                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded peer text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label :for="'display-columns-label-' + head.key"
                                        class="block w-full ml-2 text-sm font-medium text-gray-900 cursor-pointer peer-checked:text-corporate-600 peer hover:text-corporate-700 dark:text-gray-100">{{ $t(head.text) }}</label>
                                </li>
                            </ul>
                        </div>
                       
                    </div>
                   
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                            <tr>
 
                                <ConditionalHeadColumn v-for="head in _headers" :data="head" />
                               
                                <th v-if="actions !== undefined && actions !== ''">
 
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="entry in data " :key="entry.id"
                                class="transition border-b cursor-pointer dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700">
                                <!-- Conditional Body Cell -->
                                <ConditionalBodyColumn v-for="header in _headers" :key="header.key" :data="header" :cellData="renderCellData(header, entry)" />
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
                                                <a @click.prevent="router.visit(route(`vehicles.show`, entry.id ))" v-if="action === 'show'" href="#"
                                                    class="block w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{
                                                        $t('labels.show') }}</a>
                                                <a @click.prevent="router.visit(route(`vehicles.edit`, entry.id ))" v-else-if="action === 'edit'" href="#"
                                                    class="block w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{
                                                        $t('labels.edit') }}</a>
                                                <button @click="router.visit(route(`vehicles.destroy`, entry.id ))" v-if="action === 'delete'" href="#"
                                                    class="block w-full px-4 py-2 text-left text-red-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-red-700">{{
                                                        $t('labels.delete') }}</button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
 
                        </tbody>
                    </table>
                </div>
            </div>
    </section>
</template>
 
<script setup>

import { Plus, View, ArrowDown } 
    from '@element-plus/icons-vue';

import { initFlowbite } 
    from 'flowbite';

import { onMounted, ref} 
    from 'vue';

import ConditionalBodyColumn 
    from './ConditionalBodyColumn.vue';

import ConditionalHeadColumn 
    from './ConditionalHeadColumn.vue';

import { router } 
    from '@inertiajs/vue3';

import FilteredSearch 
    from '@/Components/Inputs/FilteredSearch.vue';
 
const props = defineProps({
    headers: {
        type: Array,
        required: true,
    },
    data: {
        type: Array,
        required: true,
    },
    actions: {
        type: Array,
        required: false,
    },
})
  
const storedHeaders = sessionStorage.getItem('vehicles-table-headers')
var _headers;
 
const defaultHeaders = props.headers;
 
if(storedHeaders !== 'null' && storedHeaders !== null) {
    _headers = ref(JSON.parse(storedHeaders))
} else {
    _headers = ref(defaultHeaders)
}

const updateListedItems = (key, value) => {
    _headers.value = _headers.value.map((item) => {
        if (item.key === key) {
            item.show = value
        }
        return item
    })
 
    sessionStorage.setItem('vehicles-table-headers', JSON.stringify(_headers.value))
}
 
const renderCellData = (header, data) => {
 
    switch (header.key) {
        default:
            return {'type': 'text', 'data': data[header.key] ?? "-" };
    }
}
 
onMounted(() => {
    initFlowbite();
})

 
</script>
