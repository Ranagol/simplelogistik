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
                <button class="grid grid-flow-col p-4 border-b-2 rounded-t-lg place-items-center" 
                :id="tab.id + '-tab'" 
                :data-tabs-target="'#' + tab.id" 
                type="button" 
                role="tab" 
                :aria-controls="tab.id" >
                <el-icon :size="tab.iconSize ?? 18" v-if="tab.icon" class="me-4" ><component :is="tab.icon"/></el-icon>
                {{ $t(tab.title) }}</button>
            </li>
        </ul>
    </div>
    <div id="default-tab-content" class="w-full">
        <div
            class="hidden"
            v-for="tab in config.tabs" 
            :id="tab.id" 
            role="tabpanel" 
            :aria-labelledby="tab.id + '-tab'">
            <component :is="tab.component" />
        </div>
    </div>

</template>






