<script setup>
import {router} from "@inertiajs/vue3"
    const props = defineProps({
        cellConfig: Object,
        content: Object
    });

    const cell = props.cellConfig;
    const config = cell.contentConfig;
    const cellType = config?.type ?? 'standard';
    let data = "";
    try {
        data = cell.subkey ? props.content[cell?.key][cell?.subkey] : props.content[cell?.key];
    } catch (error) {
        data = null;
    }
</script>

<template>
    <td v-if="cell.show">
        <span v-if="config">
            <span v-if="cellType == 'link'">
                <a class="cursor-pointer text-corporate-700 hover:text-corporate-500 hover:underline" @click="router.visit(route(config.to, content[config.use]))">
                    {{ data }}
                </a>
            </span>
            <span v-else-if="cellType == 'image'">
                <img v-if="data !== null" :src="data" class="object-contain w-full h-5">
                <img v-else src="https://via.assets.so/img.jpg?w=400&h=150&tc=black&bg=white&t=nodata" class="object-contain w-full h-5">
            </span>
            <span v-else-if="cellType == 'date'">
                {{ moment(data).format(config.format) }} 
            </span>
        </span>
        <span v-else-if="cellConfig.subkey">
            {{ data }}
        </span>
        <span v-else>
            <span v-if="cell.standard && (data === null || data === undefined || data === '')">{{ $t(cell.standard) }}</span>
            <span v-else>
                {{ data }}
            </span>
        </span>
    </td>
</template>