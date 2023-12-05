<template>
    
    <div class="flex flex-row mb-3">
        <h1
            class="font-semibold text-xl text-gray-800 leading-tight mr-6"
        >Edit address: </h1>

        <span
            v-if="props.address.street"
            class="font-semibold text-xl text-gray-800 leading-tight mr-6"
        >
            {{ props.address.street }}
            {{ props.address.house_number }},
            {{ props.address.zip_code }}
            {{ props.address.city }}
            {{ props.address.country }}
        </span>

        <span
            v-if="props.address.id"
            class="font-semibold text-xl text-gray-800 leading-tight mr-6"
        >Address id: {{props.address.id }}</span>

        
    </div>
</template>

<script setup>

const props = defineProps({
    address: {
        type: Object,
        required: true,
    },
});

</script>