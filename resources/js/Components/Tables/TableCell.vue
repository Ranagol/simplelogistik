<script setup>
import {router} from "@inertiajs/vue3"
    defineProps({
        cellConfig: Object,
        content: Object
    })
</script>

<template>
    <td v-if="cellConfig.show">
        <span v-if="cellConfig.contentConfig">
            <span v-if="cellConfig.contentConfig.type == 'link'">
                <a class="cursor-pointer text-corporate-700 hover:text-corporate-500 hover:underline" @click="router.visit(route(cellConfig.contentConfig.to, content[cellConfig.contentConfig.use]))">
                    {{ content[cellConfig.key] }}
                </a>
            </span>
            <span v-else-if="cellConfig.contentConfig.type == 'image'">
                <img :src="cellConfig.subkey ? content[cellConfig.key][cellConfig.subkey] : content[cellConfig.key]" class="object-contain w-full h-5">
            </span>
            <span v-else-if="cellConfig.contentConfig.type == 'date'">
                {{ moment(cellConfig.subkey ? content[cellConfig.key][cellConfig.subkey] : content[cellConfig.key]).format(cellConfig.contentConfig.format) }} 
            </span>
        </span>
        <span v-else-if="cellConfig.subkey">
            {{ content[cellConfig.key][cellConfig.subkey] }}
        </span>
        <span v-else>
            {{ content[cellConfig.key] ?? "N/A"}}
        </span>
    </td>
</template>