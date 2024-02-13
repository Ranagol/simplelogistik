<template>
    {{ records }}
</template>
<script setup>

import headers from "@/config/Tables/forwarderHeaders";
const defaultHeaders = headers;


const props = defineProps({
    records: {
        type: Object,
        required: true
    }
})
</script>