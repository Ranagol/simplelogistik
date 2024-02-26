<script setup>
import Page from '@/Components/Page.vue';
import config from "@/config/Pages/Vehicles/_edit";
import Actions from "@/config/Actions";

const actionHandle = new Actions(route().current(), route )

defineProps({
    record: {
        type: Object,
        required: true
    }
})

import { store as useStore } from "@/Stores/vehicleStore";

let vehicle = useStore()
vehicle.setOne(props.record.data)

</script>
<template>
    <Page :content="record" :page="config">
        <template #backlink>
            <button @click="actionHandle.index()">Back</button>
        </template>
    </Page>
</template>
