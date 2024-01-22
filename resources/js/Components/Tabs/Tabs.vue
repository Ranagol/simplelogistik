<template>
    
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
            <TabHeader v-for="tab in content" :target="tab.target" :title="tab.title" :icon="tab.icon" :active="tab.active" />
        </ul>
    </div>
    <div id="default-tab-content">
        <TabContent v-for="tab in content" :target="tab.target" :content="tab.content" />
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
                required: true
            }
        }
    }
</script>