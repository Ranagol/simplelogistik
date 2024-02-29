<script setup>
const props = defineProps({
    addresses: {
        type: Array,
        required: false
    },
    store: {
        type: Object,
        required: false
    }
});
</script>
<template>
    <div v-for="address in addresses" class="mt-4">
        IN PROGRESS -> Finished Do. 29.02.2024
    </div>
</template>