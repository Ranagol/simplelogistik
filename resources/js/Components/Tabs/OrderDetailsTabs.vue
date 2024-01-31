<template>
    
    <div class="grid justify-between grid-flow-col mb-4 border-b border-gray-200 place-items-center dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
            <TabHeader v-for="tab in content" :target="tab.target" :title="tab.title" :icon="tab.icon" :active="tab.active" />
        </ul>
        <div class="grid justify-end grid-flow-col gap-2">
            <button type="button"
                    class="px-3 py-2 text-sm font-medium text-white rounded-lg md:w-auto bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                {{ $t('labels.save') }}
            </button>
            <button type="button"
                class="px-3 py-2 text-sm font-medium text-white bg-red-700 rounded-lg md:w-auto hover:bg-red-800 focus:ring-4 focus:ring-primary-300 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-primary-800">
                {{ $t('labels.void') }}
            </button>
        </div>
    </div>
    <div id="default-tab-content">
        <TabContent v-for="tab in content" :target="tab.target" :content="tab.content" :tabData="tab._data" />
    </div>

</template>

<script setup>
import { initFlowbite } from 'flowbite';
import TabContent from './TabContent.vue';
import TabHeader from './TabHeader.vue';
import { onMounted } from 'vue';

onMounted(() => {
    initFlowbite()
})
</script>

<script>
    export default {
        props: {
            content: {
                type: Array,
                required: true
            },
            id: {
                type: String,
                required: false
            }
        }
    }
</script>