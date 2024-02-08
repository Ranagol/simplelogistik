<template>
    <pre>{{ data }}</pre>
</template>

<script setup>
    const props = defineProps({
        data: Object,
    })
</script>