<template>
    <nav class="flex flex-col items-start justify-between p-4 space-y-3 md:flex-row md:items-center md:space-y-0"
        aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
            {{ $t('labels.showing') }}
            <span class="font-semibold text-gray-900 dark:text-white">{{ from }} - {{ to }}</span>
            {{ $t('labels.of') }}
            <span class="font-semibold text-gray-900 dark:text-white">{{ total }}</span>
        </span>
        <pre>{{ split }}</pre>
        <ul class="inline-flex items-stretch -space-x-px border rounded-md border-primary-700 text-corporate-700">
            <li v-if="current_page > 1" @click="router.visit(first)">
                <span class="grid p-3 leading-none place-items-center min-w-fit hover:bg-primary-400 hover:text-white">
                <el-icon><DArrowLeft /></el-icon>
                </span>
            </li>
            <li v-else>
                <span class="grid p-3 leading-none text-gray-400 place-items-center min-w-fit">
                <el-icon><DArrowLeft /></el-icon>
                </span>
            </li>
            <li v-if="current_page > 1" @click="router.visit(links.path + '?page=' + (parseInt(links.current_page) - parseInt(1)))">
                <span class="grid p-3 leading-none place-items-center min-w-fit hover:bg-primary-400 hover:text-white">
                    <el-icon><ArrowLeft /></el-icon>
                </span>
            </li>
            <li v-else>
                <span class="grid p-3 leading-none text-gray-400 place-items-center min-w-fit">
                <el-icon><ArrowLeft /></el-icon>
                </span>
            </li>
        
            <!-- ITEMS -->
            <li v-for="item in items" @click="router.visit(item.url)">
                <span class="grid p-3 leading-none text-gray-400 cursor-pointer place-items-center min-w-fit hover:bg-primary-600 hover:text-white"
                :class="{'bg-primary-700 text-white cursor-default': item.active}">
                {{ item.label }}
                </span>
            </li>




            <li v-if="current_page < last_page" @click="router.visit(links.path + '?page=' + (parseInt(links.current_page) + parseInt(1)))">
                <span class="grid p-3 leading-none place-items-center min-w-fit hover:bg-primary-400 hover:text-white">
                <el-icon><ArrowRight /></el-icon>
                </span>
            </li>
            <li v-else>
                <span class="grid p-3 leading-none text-gray-400 place-items-center min-w-fit">
                <el-icon><ArrowRight /></el-icon>
                </span>
            </li>
            <li v-if="current_page < last_page" @click="router.visit(last)">
                <span class="grid p-3 leading-none place-items-center min-w-fit hover:bg-primary-400 hover:text-white">
                <el-icon><DArrowRight /></el-icon>
                </span>
            </li>
            <li v-else>
                <span class="grid p-3 leading-none text-gray-400 place-items-center min-w-fit">
                <el-icon><DArrowRight /></el-icon>
                </span>
            </li>
        </ul>
    </nav>   
</template>

<script setup>
import { ArrowLeft, DArrowLeft, ArrowRight, DArrowRight } from '@element-plus/icons-vue';
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    links: Object
})

var linksCount = props.links.links.length;

var from = props.links.from
var to = props.links.to
var total = props.links.total
var per_page = props.links.per_page
var path = props.links.path


var current_page = props.links.current_page
var last_page = props.links.last_page


var first = props.links.first_page_url;
var last = props.links.last_page_url

delete props.links.links[0];
delete props.links.links[linksCount -1];

var items = [];

props.links.links.map((link) => {
    if(link !== null) {
        var item = {
            url: link.url,
            label: link.label,
            active: link.active
        }
        items.push(item);
    }
});


</script>