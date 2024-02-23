<script setup>
import Page from '@/Components/Page.vue';
import config from "@/config/Pages/Customers/_edit";
import Actions from "@/config/Actions";

const actionHandle = new Actions(route().current(), route )
</script>
<template>
    <Page :page="config">
        <template #backlink>
            <button @click="actionHandle.index()">Back</button>
        </template>
    </Page>
</template>
