<script setup>

import Page from '@/Components/Page.vue';
import config from "@/config/Pages/Vehicles/_index";
import Actions from "@/config/Actions";
import Button from '@/Components/Buttons/Button.vue';

const actionHandle = new Actions( route )

import tableHeaderConfig from "@/config/Tables/vehicleHeaders";
import searchConfig from "@/config/SearchFilters/vehiclesSearch"; 

defineProps({
    records: {
        type: Object,
        required: true
    }
})
</script>
<template>
    <Page :metaData="records.meta" :searchConfig="searchConfig" :tableConfig="tableHeaderConfig" :content="records.data" :page="config">
        <template #create-button>
            <Button type="create" @click="actionHandle.create()"/>
        </template>
    </Page>
</template>
