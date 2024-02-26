<script setup>
    import SimpleTable from '@/Components/Tables/SimpleTable.vue';
    import ComplexTable from '@/Components/Tables/ComplexTable.vue';
    import TabContent from '@/Components/Tabs.vue';
    import Form from '@/Components/Form.vue';

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
        }
    });

</script>
<template>
    <Head :title="$t(page?.title ?? 'Page')"></Head>
    <div class="p-3 bg-white rounded-md">
        <div class="grid justify-between grid-flow-col">
            <h1 class="font-bold text-[18px] text-corporate-700">{{ $t(page?.title) }}</h1>
            <slot name="create-button" />
        </div>
        <div v-if="page.preset === 'simple-table' || page.preset === 'table'">
            <SimpleTable :tableConfig="tableConfig" :content="content" />
        </div>
        <div v-else-if="page.preset === 'complex-table'">
            <ComplexTable :contentSettings="page.bodyContentSettings" :tableConfig="tableConfig" :content="content" />
        </div>
        <div v-else-if="page.preset === 'tabs'">
            <TabContent :config="page" />
        </div>
        <div v-else-if="page.preset === 'form'">
            <Form :content="content" :useData="page.mode === 'edit'" :store="store" :form="page.form" />
        </div>
        
        <div class="grid w-full grid-cols-12 place-items-end"><slot name="actions"></slot></div>
    </div>
</template>