<script setup>
import TableCell from "@/Components/Tables/TableCell.vue"
import { ArrowDown, View } from "@element-plus/icons-vue";
const props = defineProps({
    content: {
        type: Object,
        required: true
    },
    cellConfig: {
        type: Object,
        required: true
    },
    row: {
        type: Number,
        required: true
    }
})

</script>
<template>
    <tr class="transition border-b dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700" >
        <TableCell v-for="cell, ci in cellConfig" :cellConfig="cell" :content="content" :key="ci" class="p-3"/>
    </tr>
</template>

<style scoped>
    [aria-expanded="false"] {
        transform: rotate(0deg);
        transition: transform 0.3s;
    }
    [aria-expanded="true"] {
        transform: rotate(180deg);
        transition: transform 0.3s;
    }
</style>