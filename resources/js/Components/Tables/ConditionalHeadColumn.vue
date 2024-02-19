<template>
    <th @click="() => { performOrder('id') }" :draggable="data.draggable ?? true" v-if="data.show === true"  :key="'cell-' + Math.random() + 1" scope="col" class="px-4 py-3">
        {{ $t(data.title ?? data.text) }}
    </th>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';


const props = defineProps({
    data: {
        type: Object
    },
    sort_column: {
        type: String,
        required: false
    },
    sort_order: {
        type: String,
        required: false
    },
    target_route: {
        type: String,
        required: true
    },
})

let sortColumn = ref(props.sort_column ?? "order_number");
let sortOrder = ref(props.sort_order ?? "ASC");


const performOrder = (col) => {
    sortOrder = ref(sortOrder.value === "ASC" ? "DESC" : "ASC");
    router.get(route(route().current()), 
        { 
            sortColumn: sortColumn.value,
            sortOrder: sortOrder.value
        }
    )
}

</script>