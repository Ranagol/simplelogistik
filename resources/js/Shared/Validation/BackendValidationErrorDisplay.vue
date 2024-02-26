<template>

    <!-- BACKEND VALIDATION ERROR DISPLAY -->
    <div
        v-if="props.errorMessage"
        v-text="props.errorMessage"
        class="text-red-500 text-xs mt-1"
    ></div>

</template>

<script setup>

const props = defineProps({
    errorMessage: String
});

</script>