<script setup>
import Page from '@/Components/Page.vue';
import config from "@/config/Pages/Addresses/_edit";
import Actions from "@/config/Actions";

const actionHandle = new Actions(route().current(), route )

const props = defineProps({
    record: {
        type: Object,
        required: true
    }
})

import { store as addressStore } from "@/Stores/addressStore";

let address = addressStore()

address.setOne(props.record)

</script>
<template>
    <Page :content="record" :store="address" :page="config">
        <template #backlink>
            <button @click="actionHandle.index()">Back</button>
        </template>
        <template #actions>
            <button class="p-2 px-4 text-white transition-colors duration-200 rounded-md bg-primary-700 hover:bg-primary-500" @click="address.save()">Save</button>
        </template>
    </Page>
</template>
