<template>
    <th v-if="data.show === true"  :key="'cell-' + Math.random() + 1" scope="col" class="px-4 py-3">
        {{ $t(data.title) }}
    </th>
</template>

<script setup>

const props = defineProps({
    data: {
        type: Array
    }
})

console.log(props.cellData)

const handleDragStart = (item) => {
    props.handleDragStart(item)
}

const handleDrop = (item) => {
    props.handleDrop(item)
}

const handleDragEnter = (item) => {
    props.handleDragEnter(item)
}

</script>