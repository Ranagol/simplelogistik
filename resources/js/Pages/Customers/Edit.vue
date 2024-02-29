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

<<<<<<< HEAD
let customer = customerStore()

customer.setOne(props.record)

</script>
<template>
    <Page :content="record" :store="customer" :page="config">
=======
let store = customerStore()

store.setOne(props.record)

</script>
<template>
    <Page :content="record" :store="store" :page="config">
>>>>>>> main
        <template #backlink>
            <button @click="actionHandle.index()">Back</button>
        </template>
        
        <template #actions>
<<<<<<< HEAD
            <button @click="customer.save()">Update</button>
=======
            <button class="p-2 px-4 text-white transition-colors duration-200 rounded-md bg-primary-700 hover:bg-primary-500" @click="store.save()">Speichern</button>
>>>>>>> main
        </template>
        
    </Page>
</template>
