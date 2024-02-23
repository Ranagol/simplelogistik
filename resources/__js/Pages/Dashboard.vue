<script setup>
    import Page from '@/Components/Page.vue';
    import config from "@/config/Pages/Dashboard/_index";
</script>

<template>
    <Page :page="config">
        <template #top-actions>
            <button @click="actionHandle.create()">Create</button>
        </template>
    </Page>
</template>