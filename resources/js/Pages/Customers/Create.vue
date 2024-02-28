<script setup>
import Page from '@/Components/Page.vue';
import config from "@/config/Pages/Customers/_create";
import Actions from "@/config/Actions";

const actionHandle = new Actions(route().current(), route )
import { store as customerStore } from "@/Stores/customerStore";
let store = customerStore()

store.setOne({})

</script>
<template>
    <Page :content="record" :store="store" :page="config">
        <template #backlink>
            <button @click="actionHandle.index()">Back</button>
        </template>
        <template #actions>
            <button class="p-2 px-4 text-white transition-colors duration-200 rounded-md bg-primary-700 hover:bg-primary-500" @click="store.store()">Speichern</button>
        </template>
    </Page>
</template>
