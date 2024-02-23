<script setup>
    import SimpleTable from '@/Components/Tables/SimpleTable.vue';
    import ComplexTable from '@/Components/Tables/ComplexTable.vue';

    const props = defineProps({
        page: {
            type: Object,
            required: false
        },
        content: {
            type: Array,
            required: true
        },
        tableConfig: {
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
            <ComplexTable :tableConfig="tableConfig" :content="content" />
        </div>
        <div v-else-if="page.preset === 'tabs'">
            Displays Tab and Items
        </div>
        <div v-else-if="page.preset === 'form'">
            Displays Simple Form
        </div>
    </div>
</template>