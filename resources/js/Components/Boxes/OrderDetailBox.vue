<script setup>

defineProps({
    content: {
        type: Object,
        required: true
    },
    field: {
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
<<<<<<< HEAD
    <div class="p-3 rounded-md bg-slate-100">
=======
    <div class="p-3 rounded-md bg-slate-50">
>>>>>>> main
        <span class="font-bold text-corporate-700">{{ $t(field.label) }}</span>
        <p class="pt-2">{{ !!!field.from ? content[field.field] ?? "N/A" : content[field.from][field.field] ?? "N/A"}}</p>
    </div>
</template>