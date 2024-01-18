<template>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="mx-auto max-w-screen-2xl">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <div class="w-full flex items-center space-x-3">
                        <h5 class="dark:text-white font-semibold">{{ title }}</h5>
                        <div v-if="totalResults" class="text-gray-400 font-medium">{{ totalResults }} {{ $t('labels.total-results') }}</div>
                    </div>
                    <div class="w-full flex flex-row items-center justify-end space-x-3">
                        <button type="button"
                            class="w-full md:w-auto flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">

                            <el-icon class="me-2">
                                <Plus />
                            </el-icon>
                            {{ $t('labels.create-customer') }}
                        </button>

                    </div>
                </div>
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between md:space-x-4 p-4 border-b dark:border-gray-700">

                    <div class="flex flex-row flex-1">
                        <form class="w-full md:max-w-sm flex-1 md:mr-4">
                            <label for="default-search"
                                class="text-sm font-medium text-gray-900 sr-only dark:text-white">{{ $t('labels.search') }}</label>
                            <div class="relative">
                                <input type="search" id="default-search"
                                    class="block w-full min-w-40 p-2 pr-4 pl-5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    :placeholder="$t('labels.search')">
                                <button type="submit"
                                    class="text-white absolute right-0 bottom-0 top-0 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-r-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ $t('labels.search') }}</button>
                            </div>
                        </form>

                        <button id="limitSearchFilterDropdownButton" data-dropdown-toggle="limitSearchFilterDropdown"
                        class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400"
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

                    <button id="showTableColumnsButton" data-dropdown-toggle="showTableColumns"
                        class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
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
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                            <tr>

                                <th v-for="header in headers" scope="col" class="px-4 py-3">{{ $t(header.text) }}
                                    <svg v-if="header.orderable == true" class="h-4 w-4 ml-1 inline-block"
                                        fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" />
                                    </svg>
                                </th>
                                <th v-if="actions !== undefined && actions !== ''">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="entry in data " :key="entry.id"
                                class="border-b dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer transition">

                                <td v-for="head in headers" class="px-4 py-3">
                                    {{ entry[head.key] }}
                                </td>
                                <td v-if="actions !== undefined && actions !== ''"
                                    class="px-4 py-3 flex items-center justify-end">
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
                                        class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            :aria-labelledby="'actions-dropdown-button-' + entry.id">
                                            <li v-for=" action  in  actions ">
                                                <button @click="handleShow(entry.id)" v-if="action === 'show'" href="#"
                                                    class="block w-full text-left py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{
                                                        $t('labels.show') }}</button>
                                                <button @click="handleEdit(entry.id)" v-else-if="action === 'edit'" href="#"
                                                    class="block w-full text-left py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{
                                                        $t('labels.edit') }}</button>
                                                <button @click="handleDelete(entry.id)" v-if="action === 'delete'" href="#"
                                                    class="block w-full text-left py-2 px-4 hover:bg-gray-100 text-red-700 dark:hover:bg-gray-600 dark:hover:text-red-700">{{
                                                        $t('labels.delete') }}</button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col items-start justify-between p-4 space-y-3 md:flex-row md:items-center md:space-y-0"
                    aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        {{ $t('labels.showing') }}
                    <span class="font-semibold text-gray-900 dark:text-white">{{pagination_from??1}}-{{pagination_to??10}}</span>
                        {{ $t('labels.of') }}
                    <span class="font-semibold text-gray-900 dark:text-white">{{pagination_total??20}}</span>
                    </span>
                    <ul class="inline-flex items-stretch -space-x-px">
                        <li>
                            <a :href="this.paginationData.first_page_url"
                                class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">First</span>
                                <el-icon>
                                    <DArrowLeft />
                                </el-icon>

                            </a>
                        </li>
                        <li>
                            <a :href="this.paginationData.prev_page_url"
                                class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <el-icon>
                                    <ArrowLeft />
                                </el-icon>

                            </a>
                        </li>
                        <li v-for="link in this.paginationData.links" :class="{'bg-primary-500': link.active}" :key="item">
                            <a :class="{'bg-primary-500': link.active}" :href="link.url ?? '#'"
                                class="flex items-center justify-center px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ link.label }}</a>
                        </li>
                        <li>
                            <a :href="this.paginationData.next_page_url"
                                class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <el-icon>
                                    <ArrowRight />
                                </el-icon>
                            </a>
                        </li>
                        <li>
                            <a :href="this.paginationData.last_page_url"
                                class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Last</span>
                                <el-icon>
                                    <DArrowRight />
                                </el-icon>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</template>

<script setup>
import { DArrowLeft, ArrowLeft, DArrowRight, ArrowRight, Plus } from '@element-plus/icons-vue';
import { initFlowbite } from 'flowbite';
import { onMounted, ref} from 'vue';
defineProps({
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
        type: Object,
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



onMounted(() => {
    initFlowbite();
})

const handleShow = (entry_id) => {
    alert(`handleShow for item: ${entry_id}`)
}
const handleEdit = (entry_id) => {
    alert(`handleEdit for item: ${entry_id}`)
}
const handleDelete = (entry_id) => {
    alert(`handleDelete for item: ${entry_id}`)
}

</script>

<script>

</script>
