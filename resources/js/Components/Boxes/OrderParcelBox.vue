<script setup>

defineProps({
    content: {
        type: Object,
        required: true
    },
    loadFields: {
        type: Object,
        required: true
    },
    parcelType: {
        type: String,
        required: true
    }
})
</script>

<template>
    <div class="grid col-span-1 p-3 pt-10 bg-slate-50" :key="index">
        <div class="relative" v-for="(item, index) in loadFields" :key="index">
            <span v-if="item.type == 'badge'" class="absolute p-2 py-1 text-xs text-white rounded-full -top-8 -right-1.5 bg-slate-400">{{ $t(parcelType) }}</span>
            <div class="grid">
                <div class="my-2" v-if="item.type === 'group'">
<<<<<<< HEAD
                    <p class="block font-bold">{{ $t(item.label) }}</p>
=======
                    <p class="block font-bold text-corporate-700">{{ $t(item.label) }}</p>
>>>>>>> main
                    <span v-for="field, index in item.field">
                        {{ Math.round(content[field]) }} <span v-if="index < item.field.length - 1"> x </span>
                    </span>
                </div>
                <div class="my-2" v-else-if="item.type === 'single'">
<<<<<<< HEAD
                    <p class="block font-bold">{{ $t(item.label) }}</p>
=======
                    <p class="block font-bold text-corporate-700">{{ $t(item.label) }}</p>
>>>>>>> main
                    <span>{{ content[item.field] }}</span>
                </div>
            </div>
        </div>
    </div>
</template>