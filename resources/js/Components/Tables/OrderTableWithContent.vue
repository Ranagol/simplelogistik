<template>
    <section class="bg-gray-50 dark:bg-gray-900">
            <!-- Start coding here -->
            <div class="relative bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                <div
                    class="grid items-center justify-between grid-flow-col p-4 space-y-3 border-b md:flex-row md:space-y-0 md:space-x-4 dark:border-gray-700">
                    
                    <FilteredSearch searchAt="orders.index" :search="search" :search_in="search_in" :filters="searchFilter" />
                    
                    <div class="grid grid-flow-col gap-4">
                        <!-- CREATE ORDER BUTTON -->
                        <button @click="router.visit(route('orders.create'))" type="button"
                            class="flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-white rounded-lg md:w-auto bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">

                            <el-icon class="me-2">
                                <Plus />
                            </el-icon>
                            {{ $t('page-actions.order-create') }}
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
                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">{{ $t('labels.select-fields')}}</h6>
                            <ul class="space-y-2 overflow-y-scroll text-sm max-h-48" aria-labelledby="showTableColumnsButton">
                                <li v-for="head in _headers" class="flex items-center">
                                    <input @change="(e) => updateListedItems(head.key, e.currentTarget.checked)" :id="'display-columns-label-' + head.key" type="checkbox"
                                        :value="head.key" :checked="head.show === true"
                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded peer text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label :for="'display-columns-label-' + head.key"
                                        class="block w-full ml-2 text-sm font-medium text-gray-900 cursor-pointer peer-checked:text-corporate-600 peer hover:text-corporate-700 dark:text-gray-100">{{ $t(head.title) }}</label>
                                </li>
                            </ul>
                            <div @click="restoreDefault()" class="grid w-full p-2 pt-3 cursor-pointer ps-0 hover:text-slate-400">{{ $t('labels.restore-defaults') }}</div>
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
import { ArrowDown, Plus, View } from '@element-plus/icons-vue';
import { initFlowbite } from 'flowbite';
import { onMounted } from 'vue';
import TableRowWithContent from './OrderTableRowWithContent.vue';
import { ref } from 'vue';
import ConditionalHeadColumn from './ConditionalHeadColumn.vue';
import FilteredSearch from '../Inputs/FilteredSearch.vue';
import TableHeaders from '@/lib/TableHeader';
import searchFilter from '@Config/SearchFilters/orderSearch';

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
    search: {
        type: String,
        required: false,
    },
    search_in: {
        type: Array,
        required: false,
    }
})

// TABLE HEADER HANDLING

// Initialize the empty ref
var _headers = ref();
// instantiate the TableHeader class
var tableHeaders = new TableHeaders(props.headers, "order-table-headers");
_headers.value = tableHeaders.get();

const updateListedItems = (key, value) => {
    tableHeaders.update(key, value);
    _headers.value = tableHeaders.get();
}

const restoreDefault = () => {
    tableHeaders.reset();
    _headers.value = tableHeaders.get();
}

// END TABLE HEADER HANDLING

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
