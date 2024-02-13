<template>
    <Head title="Address" />
    <ForwarderTable 
        :actions="['edit', 'show']" 
        :getData="() => {}"
        :title="$t('labels.orders')" 
        :data="fe_data.forwarders.data" 
        :headers="defaultHeaders"
    />

    <Pagination :links="buildPaginationData(fe_data.forwarders)" />
</template>
<script setup>

import ForwarderTable from "@/Components/Tables/ForwarderTable.vue";
import headers from "@/config/Tables/forwarderHeaders";
import { reactive } from "vue";
const defaultHeaders = headers;

const props = defineProps({
    records: {
        type: Object,
        required: true
    }
})

const fe_data = reactive({
    forwarders: props.records
});

</script>