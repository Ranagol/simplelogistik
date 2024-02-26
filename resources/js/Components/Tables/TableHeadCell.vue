<script setup>
    defineProps({
        cell: {
            type: Object,
            required: true
        },
    })
</script>

<template>
    <th v-if="cell.show === true" scope="col" class="p-4">
        <div class="flex items-center">
            {{ $t(cell.title) }}
        </div>
    </th>    
</template>