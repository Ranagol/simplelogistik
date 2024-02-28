<script setup>
import Page from '@/Components/Page.vue';
import config from "@/config/Pages/Customers/_edit";
import Actions from "@/config/Actions";

const actionHandle = new Actions(route().current(), route )

const props = defineProps({
    record: {
        type: Object,
        required: true
    },
    errors: {
        type: Object,
        required: false
    }
})

import { store as customerStore } from "@/Stores/customerStore";

let store = customerStore()

store.setOne(props.record)

</script>
<template>
    <Page :content="record" :store="store" :page="config">
        <template #backlink>
            <button @click="actionHandle.index()">Back</button>
        </template>
        
        <template #actions>
            <button class="p-2 px-4 text-white transition-colors duration-200 rounded-md bg-primary-700 hover:bg-primary-500" @click="store.save()">Speichern</button>
        </template>
        
    </Page>
</template>
