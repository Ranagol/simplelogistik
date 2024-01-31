<template>
    <td v-if="data.show === true" class="px-4">
        <span v-if="(typeof cellData !== 'object')">
            <span>{{ cellData.data }}</span>
        </span>
        <div v-else>
            <img v-if="cellData.type === 'image'" :src="cellData.data" alt="image" class="object-contain object-center w-16 h-8">
            <a class="text-corporate-500 hover:underline" v-else-if="cellData.type === 'link'" :href="route(cellData.target, cellData.targetID)">{{ cellData.data }}</a>
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