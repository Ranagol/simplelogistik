<template>
    <a :href="route('languages.index')">Zurück</a>
    {{ language }}
</template>

<script setup>
const props = defineProps({
    language: Object
})
</script>