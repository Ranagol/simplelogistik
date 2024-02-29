<script setup>
import Page from '@/Components/Page.vue';
import config from "@/config/Pages/Orders/_edit";
import Actions from "@/config/Actions";

let props = defineProps({
    record: {
        type: Object,
        required: true
    }
})

import { store as useStore } from "@/Stores/orderStore";

<<<<<<< HEAD
let order = useStore()
order.setOne(props.record.data)
=======
let store = useStore()
store.setOne(props.record.data)
>>>>>>> main

const actionHandle = new Actions(route().current(), route )

</script>
<template>
<<<<<<< HEAD
    <Page :content="record" :store="order" :page="config">
        <template #backlink>
            <button @click="actionHandle.index()">Back</button>
        </template>
=======
    <Page :content="record" :store="store" :page="config">
        <template #backlink>
            <button @click="actionHandle.index()">Back</button>
        </template>
        <template #actions>
            <button class="p-2 px-4 text-white transition-colors duration-200 rounded-md bg-primary-700 hover:bg-primary-500" @click="store.save()">Speichern</button>
        </template>
>>>>>>> main
    </Page>
</template>
