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

let order = useStore()
order.setOne(props.record.data)

const actionHandle = new Actions(route().current(), route )

</script>
<template>
    <Page :content="record" :store="order" :page="config">
        <template #backlink>
            <button @click="actionHandle.index()">Back</button>
        </template>
    </Page>
</template>
