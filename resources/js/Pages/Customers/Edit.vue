<script setup>
import Page from '@/Components/Page.vue';
import config from "@/config/Pages/Customers/_edit";
import Actions from "@/config/Actions";

const actionHandle = new Actions(route().current(), route )

const props = defineProps({
    record: {
        type: Object,
        required: true
    }
})

import { store as customerStore } from "@/Stores/customerStore";

let customer = customerStore()

customer.setOne(props.record)

</script>
<template>
    <Page :content="record" :store="customer" :page="config">
        <template #backlink>
            <button @click="actionHandle.index()">Back</button>
        </template>
        
        <template #actions>
            <button @click="customer.save()">Update</button>
        </template>
        
    </Page>
</template>
