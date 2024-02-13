<template>
    <div class="flex flex-row flex-1">
        <!-- SEARCH -->
        <!-- Implement Search here-->
        <form @submit="() => {}">
            <label for="search-field"
                class="text-sm font-medium text-gray-900 sr-only dark:text-white">{{ $t('labels.search') }}</label>
            <div class="relative grid grid-flow-col">
                <input 
                    type="search" 
                    id="search-field"  
                    name="searchTerm"
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
                <button @click="() => {}" type="submit"
                    class="relative top-0 bottom-0 right-0 px-4 py-2 text-sm font-medium text-white rounded-r-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ $t('labels.search') }}</button>
            </div>
        </form>
        <!-- SEARCH End -->
        <!-- Search in Fields -->
        <div id="limitSearchFilterDropdown"
            class="hidden w-auto p-3 overflow-y-scroll bg-white rounded-lg shadow max-h-96 dark:bg-gray-700">
            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">{{ $t('labels.select-fields')}}</h6>
            <ul class="space-y-2 text-sm" aria-labelledby="limitSearchFilterDropdownButton">
                <li v-for="head in headers" class="flex items-center">

                    <input @change="(e) => updateListedItems(head.key, e.currentTarget.checked)" v-if="head.searchable == true" :id="'search-label-' + head.key" type="checkbox"
                        :value="head.search_key"
                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                    <label v-if="head.searchable == true" :for="'search-label-' + head.key"
                        class="block w-full ml-2 text-sm font-medium text-gray-900 cursor-pointer hover:text-corporate-700 dark:text-gray-100">{{ $t(head.search_title ?? head.title ?? head.text) }}</label>
                </li>
            </ul>
        </div>
        <!-- Search in Fields end -->
        
    </div>
</template>

<script setup>

import { ArrowDown, Filter } from '@element-plus/icons-vue';
const props = defineProps({
    headers: {
        type: Array,
        required: true
    },
    searchAt: {
        type: String,
        required: true
    }
});



</script>