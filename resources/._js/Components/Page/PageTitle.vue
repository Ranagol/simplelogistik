<script setup>
defineProps({
    title: {
        type: String,
        required: true
    }
});
</script>

<template>
    <div class="mb-4">
        <h1 class="text-2xl font-semibold text-corporate-700">{{ $t(title) }}</h1>
    </div>
</template>