<template>
    <section class="bg-gray-50 dark:bg-gray-900">
            <!-- Start coding here -->
            <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                <div
                    class="grid items-center justify-between grid-flow-col p-4 space-y-3 border-b md:flex-row md:space-y-0 md:space-x-4 dark:border-gray-700">
                    <div class="flex flex-row flex-1">
                        <!-- SEARCH -->
                        <form class="flex-1 w-full md:max-w-sm md:mr-4">
                            <label for="search-orders"
                                class="text-sm font-medium text-gray-900 sr-only dark:text-white">{{ $t('labels.search') }}</label>
                            <div class="relative grid grid-flow-col">
                                <input type="search" id="search-orders"
                                    class="block w-full p-2 pl-5 pr-4 text-sm text-gray-900 border border-gray-300 rounded-lg rounded-e-none border-e-0 min-w-40 bg-gray-50 focus:border-gray-400 focus:ring-0 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    :placeholder="$t('labels.search')">
                                <button id="limitSearchFilterDropdownButton" data-dropdown-toggle="limitSearchFilterDropdown"
                                        class="flex items-center justify-center w-full px-2 py-2 text-sm font-medium text-gray-900 border border-gray-300 bg-gray-50 md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                    type="button">
                                        <el-icon><Filter /></el-icon>
                                        <!-- {{ $t('labels.limit-search') }} -->
                                        <el-icon size="24" class="pl-2"><ArrowDown /></el-icon>
                                </button>
                                <button @click.prevent="reorder(_headers)" type="submit"
                                    class="relative top-0 bottom-0 right-0 px-4 py-2 text-sm font-medium text-white rounded-r-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ $t('labels.search') }}</button>
                            </div>
                        </form>
                        <!-- SEARCH End -->
                        <!-- Search in Fields -->
                        <div id="limitSearchFilterDropdown"
                            class="hidden w-auto p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">{{ $t('labels.select-fields')}}</h6>
                            <ul class="space-y-2 text-sm" aria-labelledby="limitSearchFilterDropdownButton">
                                <li v-for="head in _headers" class="flex items-center">

                                    <input v-if="head.searchable == true" :id="'search-label-' + head.key" type="checkbox"
                                        :value="head.key"
                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label v-if="head.searchable == true" :for="'search-label-' + head.key"
                                        class="block w-full ml-2 text-sm font-medium text-gray-900 cursor-pointer hover:text-corporate-700 dark:text-gray-100">{{ $t(head.title) }}</label>
                                </li>
                            </ul>
                        </div>
                        <!-- Search in Fields end -->
                        
                    </div>
                    <div class="grid grid-flow-col gap-4">
                        <!-- CREATE ORDER BUTTON -->
                        <button type="button"
                            class="flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-white rounded-lg md:w-auto bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">

                            <el-icon class="me-2">
                                <Plus />
                            </el-icon>
                            {{ $t('labels.create-order') }}
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
                                        class="block w-full ml-2 text-sm font-medium text-gray-900 cursor-pointer peer-checked:text-corporate-600 peer hover:text-corporate-700 dark:text-gray-100">{{ $t(head.title) }}</label>
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 no-selection">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all" type="checkbox"
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Expand/Collapse Row</span>
                                </th>
                                <ConditionalHeadColumn
                                    v-for="col in _headers"
                                    :data="col"
                                    />
                                <th scope="col" class="px-4 py-3"><!-- Actions --></th>
                            </tr>
                        </thead>
                        <tbody data-accordion="table-column">
                            <TableRowWithContent 
                            v-for="item, index in data.data" 
                            :data="item"
                            :dataIndex="index" 
                            :actions='["show", "edit", "delete"]' 
                            :headers="_headers" />
                        </tbody>
                    </table>
                </div>
            </div>
    </section>
</template>

<script setup>
import { ArrowDown, Check, Edit, Filter, Plus, Select, View } from '@element-plus/icons-vue';
import { initFlowbite } from 'flowbite';
import { onMounted, reactive } from 'vue';
import TableRowWithContent from './OrderTableRowWithContent.vue';
import { ref } from 'vue';
import ConditionalHeadColumn from './ConditionalHeadColumn.vue';

onMounted(() => {
    initFlowbite()
})

const props = defineProps({
    headers: {
        type: Object,
        required: true
    },
    title: {
        type: String,
        required: false,
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

const storedHeaders = sessionStorage.getItem('order-table-headers')
var _headers;

const defaultHeaders = props.headers;

if(storedHeaders !== 'null' && storedHeaders !== null) {
    _headers = ref(JSON.parse(storedHeaders))
} else {
    _headers = ref(defaultHeaders)
}

const reorder = (headers) => {
    _headers = headers.sort((a,b) => a.display_order < b.display_order)
}

const updateListedItems = (key, value) => {
    _headers.value = _headers.value.map((item) => {
        if (item.key === key) {
            item.show = value
        }
        return item
    })

    sessionStorage.setItem('order-table-headers', JSON.stringify(_headers.value))
}

</script>

<script>
const handleDragStart = (item, index) => {

}
const handleDrop = (item, index) => {

}
const handleDragEnter = (item, index) => {
}

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
