<script setup>

import Page from '@/Components/Page.vue';
import config from "@/config/Pages/Orders/_index";
import Actions from "@/config/Actions";
import Button from '@/Components/Buttons/Button.vue';

const actionHandle = new Actions( route )

import tableHeaderConfig from "@/config/Tables/orderHeaders"; 

defineProps({
    records: {
        type: Array,
        required: true
    }
})
</script>
<template>
    <Page :tableConfig="tableHeaderConfig" :content="records.data" :page="config">
        <template #create-button>
            <Button type="create" @click="actionHandle.create()"/>
        </template>
    </Page>
</template>
