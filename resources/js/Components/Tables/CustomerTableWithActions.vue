<template>
    <section class="bg-gray-50 dark:bg-gray-900">
            <!-- Start coding here -->
            <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                
                <div
                    class="grid items-center justify-between grid-flow-col p-4 space-y-3 border-b md:flex-row md:space-y-0 md:space-x-4 dark:border-gray-700">
                    
                    <FilteredSearch :searchTerm="data" searchAt="customers.index" :headers="_headers" />

                    <div class="grid grid-flow-col gap-4">
                        <!-- CREATE ORDER BUTTON -->
                        <button type="button"
                            class="flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-white rounded-lg md:w-auto bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">

                            <el-icon class="me-2">
                                <Plus />
                            </el-icon>
                            {{ $t('labels.create-customer') }}
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
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                            <tr>

                                <th v-for="header in _headers" scope="col" class="px-4 py-3">{{ $t(header.text) }}
                                    <svg v-if="header.orderable == true" class="inline-block w-4 h-4 ml-1"
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
                                class="transition border-b cursor-pointer dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700">

                                <td v-for="head in _headers" class="px-4 py-3">
                                    <span v-if="head.key == 'private_customer' && entry['private_customer'] == true" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">{{ $t('labels.customer-private') }}</span>
                                    <span v-else-if="head.key == 'private_customer' && entry['private_customer'] == false" class="bg-purple-100 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-300">{{ $t('labels.customer-business') }}</span>
                                    <span v-else>{{ entry[head.key] }}</span>
                                </td>
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
                                                <a @click="router.visit(route(`customers.show`, entry.id ))" v-if="action === 'show'" href="#"
                                                    class="block w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{
                                                        $t('labels.show') }}</a>
                                                <a @click="router.visit(route(`customers.show`, entry.id ))" v-else-if="action === 'edit'" href="#"
                                                    class="block w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{
                                                        $t('labels.edit') }}</a>
                                                <button @click="router.visit(route(`customers.destroy`, entry.id ))" v-if="action === 'delete'" href="#"
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
import { Plus, View, ArrowDown, Filter } from '@element-plus/icons-vue';
import { router } from '@inertiajs/vue3';
import { initFlowbite } from 'flowbite';
import { onMounted, ref} from 'vue';
import FilteredSearch from '@/Components/Inputs/FilteredSearch.vue';

const props = defineProps({
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

const _headers = props.headers;

onMounted(() => {
    initFlowbite();
})
</script>
