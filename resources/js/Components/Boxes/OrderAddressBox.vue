<script setup>
import { ref } from 'vue';
defineProps({
    content: {
        type: Object,
        required: true
    },
    loadFields: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <div class="grid col-span-1 p-3 pt-10 bg-slate-50" :key="index">
        <div class="relative" v-for="(item, index) in loadFields" :key="index">
            <span v-if="item.type == 'badge'" class="absolute p-2 py-1 text-xs text-white rounded-full -top-8 -right-1.5 bg-primary-500">{{ $t(content[item.field]) }}</span>
            <span v-else-if="item.type === 'group'">
                <span v-for="field in item.field">
                    {{ content[field] }}
                </span>
            </span>
            <span v-else-if="item.type === 'single'">
                <span v-if="typeof content[item.field] === 'object'">{{ content[item.field]?.country_name ?? "" }}</span>
                <span v-else>{{ content[item.field] }}</span>
            </span>
        </div>
    </div>
</template>