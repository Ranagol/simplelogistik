<script setup>
import Page from '@/Components/Page.vue';
import config from "@/config/Pages/Forwarders/_create";
import Actions from "@/config/Actions";

const actionHandle = new Actions(route().current(), route )

const props = defineProps({
    record: {
        type: Object,
        required: true
    }
})

import { store as useStore } from "@/Stores/forwarderStore";

let forwarder = useStore()
forwarder.setOne(props.record.data)

</script>
<template>
    <Page :content="record" :store="forwarder" :page="config">
        <template #backlink>
            <button @click="actionHandle.index()">Back</button>
        </template>
        <template #actions>
            <button @click="forwarder.store()">Update</button>
        </template>
    </Page>
</template>
