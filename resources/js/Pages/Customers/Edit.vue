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
    <Page :content="record" :store="store" :page="config" />
</template>
