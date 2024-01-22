<template>
    <section class="bg-gray-50 dark:bg-gray-900">
            <!-- Start coding here -->
            <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                <div
                    class="flex flex-col items-center justify-between p-4 space-y-3 border-b md:flex-row md:space-y-0 md:space-x-4 dark:border-gray-700">
                    <div class="flex items-center w-full space-x-3">
                        <h5 class="font-semibold dark:text-white">{{ title }}</h5>
                        <div v-if="totalResults" class="font-medium text-gray-400">{{ totalResults }} {{ $t('labels.total-results') }}</div>
                    </div>
                    <div class="flex flex-row items-center justify-end w-full space-x-3">
                        <button type="button"
                            class="flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-white rounded-lg md:w-auto bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">

                            <el-icon class="me-2">
                                <Plus />
                            </el-icon>
                            {{ $t('labels.create-order') }}
                        </button>

                    </div>
                </div>
                <div class="flex flex-col items-start justify-between p-4 border-b md:flex-row md:items-center md:space-x-4 dark:border-gray-700">

                    <div class="flex flex-row flex-1">
                        <form class="flex-1 w-full md:max-w-sm md:mr-4">
                            <label for="default-search"
                                class="text-sm font-medium text-gray-900 sr-only dark:text-white">{{ $t('labels.search') }}</label>
                            <div class="relative">
                                <input type="search" id="default-search"
                                    class="block w-full p-2 pl-5 pr-4 text-sm text-gray-900 border border-gray-300 rounded-lg min-w-40 bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    :placeholder="$t('labels.search')">
                                <button @click.prevent="reorder(_headers)" type="submit"
                                    class="absolute top-0 bottom-0 right-0 px-4 py-2 text-sm font-medium text-white rounded-r-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ $t('labels.search') }}</button>
                            </div>
                        </form>

                        <button id="limitSearchFilterDropdownButton" data-dropdown-toggle="limitSearchFilterDropdown"
                        class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400"
                                viewbox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $t('labels.limit-search') }}
                            <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                        <div id="limitSearchFilterDropdown"
                            class="hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">{{ $t('labels.select-fields')}}</h6>
                            <ul class="space-y-2 text-sm" aria-labelledby="limitSearchFilterDropdownButton">
                                <li v-for="head in _headers" class="flex items-center">

                                    <input v-if="head.searchable == true" :id="'search-label-' + head.key" type="checkbox"
                                        :value="head.key"
                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label v-if="head.searchable == true" :for="'search-label-' + head.key"
                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $t(head.text) }}</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex flex-col justify-end">

                    </div>

                    <button id="showTableColumnsButton" data-dropdown-toggle="showTableColumns"
                        class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        type="button">
                        {{ $t('labels.arrange-columns') }}
                        <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                    <div id="showTableColumns"
                        class="hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                        <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">{{ $t('labels.select-fields')}}</h6>
                        <ul class="space-y-2 text-sm" aria-labelledby="showTableColumnsButton">
                            <li v-for="head in _headers" class="flex items-center">

                                <input v-if="head.searchable == true" :id="'search-label-' + head.key" type="checkbox"
                                    :value="head.key"
                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label v-if="head.searchable == true" :for="'search-label-' + head.key"
                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $t(head.text) }}</label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 no-selection">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                            <tr >
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
                                
                                <th draggable="true" v-for="(item, index) in _headers" :key="index" scope="col" @dragstart="handleDragStart(item)" @dragover="handleDragEnter(item)" @dragend="handleDrop(item)" class="px-4 py-3">
                                    {{ item.title }}
                                    <svg v-if="item.sortable" class="inline-block w-4 h-4 ml-1" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" />
                                    </svg>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody data-accordion="table-column">
                            <TableRowWithContent :actions='["show", "edit", "delete"]' v-for="item, index in data" :data="item" :dataIndex="index" :headers="_headers"></TableRowWithContent>
                        </tbody>
                    </table>
                </div>

                <Pagination :links="paginationData" />
            </div>
    </section>
</template>

<script setup>
import Pagination from '@/Components/Pagination/Pagination.vue';
import { ArrowDown, Check, Edit, Plus, Select, View } from '@element-plus/icons-vue';
import { initFlowbite } from 'flowbite';
import { onMounted } from 'vue';
import TableRowWithContent from './TableRowWithContent.vue';
import { ref } from 'vue';

onMounted(() => {
    initFlowbite()
})

const props = defineProps({
    headers: {
        type: Object,
        required: true
    },
    changeTableLayout: {
        type: Function,
        required: false
    },
    handleDragStart: {
        type: Function,
        required: false
    },
    handleDrop: {
        type: Function,
        required: false
    },
    handleDragEnter: {
        type: Function,
        required: false
    },
    getData: {
        type: Function,
        required: true,
    },
    paginationData: {
        type: Object,
        required: true,
    },
    totalResults: {
        type: Number,
        required: false,
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

var _headers = ref(props.headers)

const reorder = (headers) => {
    _headers = headers.sort((a,b) => a.display_order < b.display_order)
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