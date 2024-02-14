<template>
    <section class="bg-gray-50 dark:bg-gray-900">
            <!-- Start coding here -->
            <div class="relative bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                <div v-if="title"
                    class="flex flex-col items-center justify-between p-4 space-y-3 border-b md:flex-row md:space-y-0 md:space-x-4 dark:border-gray-700">
                    <div class="flex items-center w-full space-x-3">
                        <h5 class="font-semibold dark:text-white">{{ $t(title) }}</h5>
                        <div v-if="totalResults" class="font-medium text-gray-400">{{ totalResults }} {{ $t('labels.total-results') }}</div>
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
                                <button type="submit"
                                    class="absolute top-0 bottom-0 right-0 px-4 py-2 text-sm font-medium text-white rounded-r-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ $t('labels.search') }}</button>
                            </div>
                        </form>

                        <button :id="'limitSearchFilterDropdownButton' + uKey" :data-dropdown-toggle="'limitSearchFilterDropdown' + uKey"
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
                        <div :id="'limitSearchFilterDropdown' + uKey"
                            class="hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">{{ $t('labels.select-fields')}}</h6>
                            <ul class="space-y-2 text-sm" :aria-labelledby="'limitSearchFilterDropdownButton' + uKey">
                                <li v-for="head in headers" class="flex items-center">

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

                    <button :id="'showTableColumnsButton' + uKey" :data-dropdown-toggle="'showTableColumns' + uKey"
                        class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        type="button">
                        {{ $t('labels.arrange-columns') }}
                        <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                    <div :id="'showTableColumns' + uKey"
                        class="z-50 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                        <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">{{ $t('labels.select-fields')}}</h6>
                        <ul class="space-y-2 text-sm" :aria-labelledby="'showTableColumnsButton' + uKey">
                            <li v-for="head in headers" class="flex items-center">

                                <input @change="(e) => updateTableColumnVisibility(head.key, e.target.checked)" :id="'search-label-' + uKey + head.key" :checked="head.show === true" type="checkbox"
                                    :value="head.key"
                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label :for="'search-label-' + uKey + head.key"
                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $t(head.text) }}</label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <ConditionalHeadColumn v-for="head in headers" :data="head" />
                                <th v-if="actions !== undefined && actions !== ''">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="entry in data" :key="entry.id"
                                class="transition border-b cursor-pointer dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700">

                                <ConditionalBodyColumn v-for="head in headers" :data="head" :cellData="renderCellData(head, entry)" />
                                <td class="flex items-center justify-end px-4 py-3">
                                    <button @click="this.window.open(entry.download_path, '_self', 'popup=1')" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                        type="button">
                                        <el-icon><Download /></el-icon>
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            
            </div>
    </section>
</template>

<script setup>
import { DArrowLeft, ArrowLeft, DArrowRight, ArrowRight, Plus, Download } from '@element-plus/icons-vue';
import { initFlowbite } from 'flowbite';
import { onMounted, ref} from 'vue';
import ConditionalBodyColumn from './ConditionalBodyColumn.vue';
import ConditionalHeadColumn from './ConditionalHeadColumn.vue';
import { reactive } from 'vue';
const props = defineProps({
    uKey: {
        type: String,
        required: true,
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
    headers: {
        type: Array,
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
    updateTableColum: {
        type: Function,
        required: false,
    },
})

// Reformat Cell Data
const renderCellData = (header, data) => {
    switch (header.key) {
        default:
            return {'type': 'text', 'data': data[header.key] };
    }
}

onMounted(() => {
    initFlowbite();
})


</script>

<script>

</script>
