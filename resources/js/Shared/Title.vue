<template>
    <h1
        class="font-semibold text-xl text-gray-800 leading-tight mr-6 mb-3"
    >{{ props.title }}</h1>
</template>

<script setup>

const props = defineProps({
    title: {
        type: String,
        required: true
    }
})

</script>