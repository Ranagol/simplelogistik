<template>
    <div class="flex flex-row flex-1">
        <!-- SEARCH -->
        <!-- Implement Search here-->
        <form @submit="() => performSearch()">
            <label for="search-field"
                class="text-sm font-medium text-gray-900 sr-only dark:text-white">{{ $t('labels.search') }}</label>
            <div class="relative grid grid-flow-col">
                <input 
                    type="text" 
                    id="search-field"  
                    name="searchTerm"
                    v-model="searchTerm"
                    class="block w-full p-2 pl-5 pr-4 text-sm text-gray-900 border border-gray-300 rounded-lg rounded-e-none border-e-0 min-w-40 bg-gray-50 focus:border-gray-400 focus:ring-0 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    :placeholder="$t('labels.search')">
                <button 
                    id="limitSearchFilterDropdownButton" 
                    data-dropdown-toggle="limitSearchFilterDropdown"
                        class="flex items-center justify-center w-full px-2 py-2 text-sm font-medium text-gray-900 border border-gray-300 bg-gray-50 md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    type="button">
                        <el-icon><Filter /></el-icon>
                        <el-icon size="24" class="pl-2"><ArrowDown /></el-icon>
                </button>
                <!-- Implement Search here-->
                <button @click="() => performSearch()" type="button"
                    class="relative top-0 bottom-0 right-0 px-4 py-2 text-sm font-medium text-white rounded-r-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ $t('labels.search') }}</button>
            </div>
        </form>
        <!-- SEARCH End -->
        <!-- Search in Fields -->
        <div id="limitSearchFilterDropdown"
            class="hidden w-auto p-3 overflow-y-scroll bg-white rounded-lg shadow max-h-96 dark:bg-gray-700">
            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">{{ $t('labels.select-fields')}}</h6>
            <ul class="space-y-2 text-sm" aria-labelledby="limitSearchFilterDropdownButton">
                <div v-for="section in filters">
                    <li><span class="block p-2">{{ $t(section.section) }}</span></li>
                    <li v-for="item in section.fields" class="flex items-center mb-1">
                        <label class="grid justify-start w-full grid-flow-col ml-2 text-sm font-medium text-gray-900 cursor-pointer place-items-center hover:text-corporate-700 dark:text-gray-100">
                            <input :checked="isChecked(section.relation, item.name)" @change="e => setFilter(section.relation, item.name, e.target.checked)" type="checkbox" 
                                 class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <span class="ps-2"></span>{{ section.relation ? $t(`labels.` + section.relation) + " - " : '' }}{{ $t(item.label) }}
                        </label>
                    </li>
                </div>
            </ul>
        </div>
        <!-- Search in Fields end -->
    </div>
</template>

<script setup>

import { ArrowDown, Filter } from '@element-plus/icons-vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    filters: {
        type: Array,
        required: true
    },
    search_in: {
        type: Array,
        required: true
    },
    search: {
        type: String,
        required: true
    },
    sort_column: {
        type: String,
        required: false
    },
    sort_order: {
        type: String,
        required: false
    },
});

let searchTerm = ref(props.search ?? '');
let activeFilters = ref(props.search_in ?? []);
let sortColumn = ref(props.sort_column ?? "order_number");
let sortOrder = ref(props.sort_order ?? "DESC");

function setFilter(relation, field, state) {
    if(relation) {
        var searchAt = relation + '__' + field;
    } else {
        var searchAt = field;
    }

    if(state) {
        activeFilters.value.push(searchAt);
    } else {
        activeFilters.value = activeFilters.value.filter(item => item !== searchAt);
    }
}

function isChecked(relation, field) {
    if(relation) {
        var searchAt = relation + '__' + field;
    } else {
        var searchAt = field;
    }
    return activeFilters.value.includes(searchAt);
   // console.log(relation, field, activeFilters.target);
}

const performSearch = () => {

    router.get(route(route().current()),
        { 
            searchTerm: searchTerm.value, 
            searchIn: activeFilters.value,
            sortColumn: sortColumn.value,
            sortOrder: sortOrder.value
        }
    )
}


</script>