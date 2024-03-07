<script setup>
import {router} from "@inertiajs/vue3"
    const props = defineProps({
        cellConfig: Object,
        content: Object
    });

    const cell = props.cellConfig;
    const config = cell.contentConfig;
    const cellType = config?.type ?? 'standard';
    const data = cell.subkey ? props.content[cell.key][cell.subkey] : props.content[cell.key]
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
                <img v-if="data" :src="data" class="object-contain w-full h-5">
                <span v-else>{{ $t('labels.general.messages.no_image_present') }}</span>
            </span>
            <span v-else-if="cellType == 'date'">
                {{ moment(data).format(config.format) }} 
            </span>
        </span>
        <span v-else-if="cellConfig.subkey">
            {{ data }}
        </span>
        <span v-else>
            <span v-if="cell.standard && (data === null || data === undefined || data === "")">{{ $t(cell.standard) }}</span>
            <span v-else>
                {{ data }}
            </span>
        </span>
    </td>
</template>