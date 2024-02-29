<script setup>
import Page from '@/Components/Page.vue';
import config from "@/config/Pages/Forwarders/_edit";
import Actions from "@/config/Actions";

const actionHandle = new Actions(route().current(), route )

const props = defineProps({
    record: {
        type: Object,
        required: true
    }
})

import { store as useStore } from "@/Stores/forwarderStore";

<<<<<<< HEAD
let forwarder = useStore()
forwarder.setOne(props.record.data)

</script>
<template>
    <Page :content="record" :store="forwarder" :page="config">
=======
let store = useStore()
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
            <button @click="forwarder.save()">Update</button>
=======
            <button class="p-2 px-4 text-white transition-colors duration-200 rounded-md bg-primary-700 hover:bg-primary-500" @click="store.save()">Speichern</button>
>>>>>>> main
        </template>
    </Page>
</template>
