<template>
    <td v-if="data.show === true" class="px-4">
        {{ cellData }}
    </td>
</template>

<script setup>

const props = defineProps({
    data: {
        type: Object
    },
    cellData: {
        type: Object
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