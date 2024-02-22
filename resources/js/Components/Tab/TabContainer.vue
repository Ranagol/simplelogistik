<script setup>
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';
import FormContainer from '@/Components/Forms/FormContainer.vue';
import TimelineContainer from '@/Components/Forms/TimelineContainer.vue';
import TableContainer from '@/Components/Forms/TableContainer.vue';
import PageActions from '@/Components/Page/PageActions.vue';
defineProps({
    config: {
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
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" 
            :id="config.id + '-tab'" 
            :data-tabs-toggle="config.id + '-content'" 
            data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" 
            data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" 
            role="tablist">
            <li class="me-2" v-for="tab in config.tabs" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" 
                    :id="tab.id + '-tab'" 
                    :data-tabs-target="'#content-' + tab.id" 
                    type="button" 
                    role="tab" 
                    aria-controls="profile" 
                    aria-selected="false">{{ $t(tab.title) }}</button>
            </li>
        </ul>
    </div>
    <div :id="config.id + '-content'">
        <div v-for="tab in config.tabs" class="hidden" 
            :id="'content-' + tab.id" 
            role="tabpanel" 
            :aria-labelledby="tab.id + '-tab'">
            <PageActions v-if="tab.content.actions" position="top" :actions="tab.content.actions" />
            
            <FormContainer :mode-edit="modeEdit" v-if="tab.content.preset === 'form'" :config="tab.content" />
            <TimelineContainer :mode-edit="modeEdit" v-else-if="tab.content.preset === 'timeline|input'" :config="tab.content" />
            <TableContainer :mode-edit="modeEdit" v-else-if="tab.content.preset === 'table'" :config="tab.content" />

            <PageActions v-if="tab.content.actions" position="bottom" :actions="tab.content.actions" />
        </div>
    </div>
</template>