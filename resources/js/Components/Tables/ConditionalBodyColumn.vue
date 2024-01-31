<template>
    <td v-if="data.show === true" class="px-4">
        <span v-if="(typeof cellData !== 'object')">
                <span>{{ cellData.data }}</span>
        </span>
        <div v-else>
            <img v-if="cellData.type === 'image'" :src="cellData.data" alt="image" class="w-16 h-8 border-2">
            <span v-else>{{ cellData.data }}</span>
        </div>
    </td>
</template>

<script setup>

const props = defineProps({
    data: {
        type: Object
    },
    cellData: {
        type: String
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