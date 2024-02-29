<script setup>
    import { Search } from '@element-plus/icons-vue';
    import { initFlowbite } from 'flowbite';
    import { onMounted, ref } from 'vue';
    import SimpleTableContent from '@/Components/Tables/SimpleTableContent.vue';
    import TableHeaders from "@/lib/TableHeaders";
    import TableHeadCell from '@/Components/Tables/TableHeadCell.vue';
import Pagination from '../Pagination/Pagination.vue';
<<<<<<< HEAD
=======
import SearchFilter from '../Inputs/SearchFilter.vue';
>>>>>>> main
    const props = defineProps({
        content: {
            type: Object,
            required: true
        },
        metaData: {
            type: Object,
            required: true
        },
        tableConfig: {
            type: Object,
            required: true
<<<<<<< HEAD
        }
=======
        },
        searchConfig: {
            type: Object,
            required: true
        },
>>>>>>> main
    })

    onMounted(() => {
        initFlowbite();
    })

    const headerHelper = new TableHeaders(props.tableConfig ?? [], route().current() + "-headers");

    var headers = ref(headerHelper.get());
    
    function update(key, val){
        headerHelper.update(key, val);
        headers.value = headerHelper.get();
    }
    
    function reset(){
        headerHelper.reset();
        headers.value = headerHelper.get();
    }

</script>

<template>
    <div class="relative mt-5 bg-white dark:bg-gray-800 sm:rounded-lg">
        <div class="grid justify-between grid-flow-col py-3">
            <div>
<<<<<<< HEAD
                <button id="search-filter-dropdown-button" data-dropdown-toggle="search-filter-dropdown" class="flex items-center justify-center w-full gap-2 px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                    <el-icon><Search /></el-icon>
                    <span>Search Filter</span>
                </button>
                <div id="search-filter-dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="search-filter-dropdown-button">
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass Edit</a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete all</a>
                    </div>
                </div>
=======
                <SearchFilter :searchConfig="searchConfig" />
>>>>>>> main
            </div>
            <div>
                <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                    <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg>
                    {{ $t('buttons.general.arrange') }}
                </button>
                <div id="actionsDropdown" class="z-50 hidden bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="grid gap-2 py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                        <li v-for="header, index in headers" :key="index">
                            <label :for="header.key" class="flex w-full gap-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                <input type="checkbox" :id="header.key" :checked="header.show" @change="e => update(header.key, e.target.checked)"/>
                                {{ $t(header.title) }}
                            </label>
                        </li>
                    </ul>
                    <div class="py-1">
                        <button @click="reset()" class="grid w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">{{ $t('buttons.general.reset')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <TableHeadCell v-for="item, index in headers" :cell="item" :key="index" scope="col" class="px-4 py-3" />
                    </tr>
                </thead>
                <tbody data-accordion="table-column">
                    <SimpleTableContent v-for="(item, index) in content" :key="index" :cellConfig="headers" :row="index" :content="item" />
                </tbody>
            </table>
        </div>
        <Pagination v-if="metaData" :links="metaData" />
    </div>
</template>