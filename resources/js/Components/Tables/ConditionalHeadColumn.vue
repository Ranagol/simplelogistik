<template>
    <th :draggable="data.draggable ?? true" v-if="data.show === true"  :key="'cell-' + Math.random() + 1" scope="col" class="px-4 py-3">
        {{ $t(data.title ?? data.text) }}
    </th>
</template>

<script setup>

const props = defineProps({
    data: {
        type: Object
    }
})

</script>