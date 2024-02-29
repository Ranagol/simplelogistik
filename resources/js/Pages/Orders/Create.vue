<script setup>
import Page from '@/Components/Page.vue';
import config from "@/config/Pages/Orders/_create";
import Actions from "@/config/Actions";
<<<<<<< HEAD
=======

const actionHandle = new Actions(route().current(), route )

import { store as useStore } from "@/Stores/orderStore";

let store = useStore()
store.setOne({})
>>>>>>> main

const actionHandle = new Actions(route().current(), route )
</script>
<template>
<<<<<<< HEAD
    <Page :page="config">
        <template #backlink>
            <button @click="actionHandle.index()">Back</button>
        </template>
=======
    <Page :store="store" :page="config">
        <template #backlink>
            <button @click="actionHandle.index()">Back</button>
        </template>
        <template #actions>
            <button class="p-2 px-4 text-white transition-colors duration-200 rounded-md bg-primary-700 hover:bg-primary-500" @click="store.store()">Speichern</button>
        </template>
>>>>>>> main
    </Page>
</template>
