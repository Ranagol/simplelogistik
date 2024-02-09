<template>
    {{ records }}
</template>
<script setup>


const props = defineProps({
    records: {
        type: Object,
        required: true
    }
})
</script>