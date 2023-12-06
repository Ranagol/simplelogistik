<template>
    
    <!-- CREATE OR EDIT as title -->
    <div class="flex flex-row mb-3">

        <!-- ADDRESS DETAILS -->
        <h1
            class="font-semibold text-xl text-gray-800 leading-tight mr-6"
        >
            {{ props.headerText }}
        </h1>

    </div>
</template>

<script setup>

const props = defineProps({
    record: {
        type: Object,
        required: true,
    },

    mode: {
        type: String,
        required: true,
    },

    headerText: {
        type: String,
        required: true,
    },
});

</script>