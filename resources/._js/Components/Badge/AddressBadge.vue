<template>
    <span v-if="variant === 'billing'" class="absolute block px-2 text-[12px] text-white rounded-sm top-2 right-2 bg-primary-600">
        {{ $t(label) }}
    </span>
    <span v-else-if="variant === 'pickup'" class="absolute block px-2 text-[12px] text-white rounded-sm top-2 right-2 bg-primary-600">
        {{ $t(label) }}
    </span>
    <span v-else-if="variant === 'delivery'" class="absolute block px-2 text-[12px] text-white rounded-sm top-2 right-2 bg-primary-600">
        {{ $t(label) }}
    </span>
    <span v-else-if="variant === 'headquarter'" class="absolute block px-2 text-[12px] text-white rounded-sm top-2 right-2 bg-primary-600">
        {{ $t(label) }}
    </span>
    <span v-else  class="absolute block px-2 text-[12px] text-white rounded-sm top-2 right-2 bg-primary-600">
        {{ $t(label) }}
    </span>
</template>

<script setup>
const props = defineProps({
    label: {
        type: String,
        required: true
    },
    variant: {
        type: String,
        required: true
    }
})
</script>