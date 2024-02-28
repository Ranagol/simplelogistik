<script setup>
    import SimpleTable from '@/Components/Tables/SimpleTable.vue';
    import ComplexTable from '@/Components/Tables/ComplexTable.vue';
    import TabContent from '@/Components/Tabs.vue';
    import Form from '@/Components/Form.vue';
    import { ArrowLeft } from '@element-plus/icons-vue';
    import route from 'ziggy-js';
    import { router } from '@inertiajs/vue3';

    const props = defineProps({
        page: {
            type: Object,
            required: false
        },
        content: {
            type: Object,
            required: true
        },
        tableConfig: {
            type: Object,
            required: false
        },
        store: {
            type: Object,
            required: false
        },
        metaData: {
            type: Object,
            required: false
        }
    });

    const index = route().current().split('.')[0] + ".index";
    const current = route().current();
</script>
<template>
    <Head :title="$t(page?.title ?? 'Page')"></Head>
    <div class="justify-between mb-4">
        <div v-if='index !== current'>
            <button class="grid justify-center grid-flow-col gap-2 place-items-center" @click="router.visit(route(index))"><el-icon><ArrowLeft /></el-icon>{{$t('buttons.general.back')}}</button>
        </div>
        <div class="grid place-items-end">
            <slot name="create-button" />
        </div>
    </div>
    <div class="p-3 bg-white rounded-md">
        <div class="grid justify-between grid-flow-col">
            <h1 class="font-bold text-[18px] text-corporate-700">{{ $t(page?.title) }}</h1>
        </div>
        <div v-if="page.preset === 'simple-table' || page.preset === 'table'">
            <SimpleTable :metaData="metaData" :tableConfig="tableConfig" :content="content" />
        </div>
        <div v-else-if="page.preset === 'complex-table'">
            <ComplexTable :metaData="metaData" :contentSettings="page.bodyContentSettings" :tableConfig="tableConfig" :content="content" />
        </div>
        <div v-else-if="page.preset === 'tabs'">
            <TabContent :config="page" />
        </div>
        <div v-else-if="page.preset === 'form'">
            <Form :content="content" :useData="page.mode === 'edit'" :store="store" :form="page.form" />
        </div>
        
        <div class="grid justify-end place-items-end">
            <slot name="actions"></slot>
        </div>
    </div>
</template>