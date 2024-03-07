<script setup>
    defineProps({
        cell: {
            type: Object,
            required: true
        },
    })
</script>

<template>
    <th v-if="cell.show === true" scope="col" class="px-4">
        {{ $t(cell.title) }}
    </th>    
</template>