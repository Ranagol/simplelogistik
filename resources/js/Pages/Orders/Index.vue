<script setup>

import Page from '@/Components/Page.vue';
import config from "@/config/Pages/Orders/_index";
import Actions from "@/config/Actions";
import Button from '@/Components/Buttons/Button.vue';

const actionHandle = new Actions( route )

import tableHeaderConfig from "@/config/Tables/orderHeaders"; 
<<<<<<< HEAD

=======
import searchConfig from "@/config/SearchFilters/orderSearch"; 
>>>>>>> main
defineProps({
    records: {
        type: Object,
        required: true
    }
})

</script>
<template>
<<<<<<< HEAD
    <Page :metaData="records.meta" :tableConfig="tableHeaderConfig" :content="records.data" :page="config">
=======
    <Page :metaData="records.meta" :searchConfig="searchConfig" :tableConfig="tableHeaderConfig" :content="records.data" :page="config">
>>>>>>> main
        <template #create-button>
            <Button type="create" @click="actionHandle.create()"/>
        </template>
    </Page>
</template>
