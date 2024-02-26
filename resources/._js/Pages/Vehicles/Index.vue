<template>
    <Head
        :title="$t('labels.vehicles')"
    />
    <VehiclesTable
        :actions="['show', 'edit']"
        :title="$t('labels.customers')"
        :data="fe_data.vehicles.data"
        :headers="defaultHeaders"
        :props="props"
    ></VehiclesTable>
    <Pagination :links="buildPaginationData(fe_data.vehicles)" />
</template>

<script setup>
    import { reactive } from 'vue';
    import VehiclesTable from "@/Components/Tables/VehiclesTable.vue";

    import headers from "@/config/Tables/vehicleHeaders";
    const defaultHeaders = headers;

    const props = defineProps({
        records: Object,
    })

    const fe_data = reactive({
        vehicles: props.records,
    });

</script>