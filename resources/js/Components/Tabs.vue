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
    <div class="grid justify-between grid-flow-col mb-4 border-b border-gray-200 dark:border-gray-700 place-items-center">
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
        <div class="grid grid-flow-col gap-4">
            <button v-if="config.actions" v-for="action in config.actions" @click="action.handler(content)" class="p-2 px-4 text-white rounded-md bg-primary-700 hover:bg-primary-600" :class="action.class">{{ $t(action.title) }}</button>
        </div>
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






