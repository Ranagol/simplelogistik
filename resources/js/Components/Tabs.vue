<script setup>
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';

defineProps({
    config: {
        type: Object,
        required: true
    },
    content: {
        type: Object,
        required: true
    }
});

onMounted(() => {
    initFlowbite();
});

</script>
<template>
    
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
            <li v-for="tab in config.tabs" class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" 
                :id="tab.id + '-tab'" 
                :data-tabs-target="'#' + tab.id" 
                type="button" 
                role="tab" 
                :aria-controls="tab.id" >{{ tab.title }}</button>
            </li>
        </ul>
    </div>
    <div id="default-tab-content">
        <div
            class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
            v-for="tab in config.tabs" 
            :id="tab.id" 
            role="tabpanel" 
            :aria-labelledby="tab.id + '-tab'">
            <component :form="config" :content="content" :is="tab.component" />
        </div>
    </div>

</template>






