<template>
    <button :disabled="disabled" class="p-4 py-3 text-white rounded-md" :class="cssClass(variant)" >
        {{ text ?? ''}}
    </button>
</template>


<script setup>
import { computed } from 'vue';

    const props = defineProps({
        text: String,
        click: Function,
        variant: String,
        type: String,
        disabled: Boolean
    });

    const cssClass = (variant) => {
        switch (variant) {
            case 'primary':
                return 'bg-primary-700';
            case 'danger':
                return 'bg-red-700';
            case 'success':
                return 'bg-green-700';
            case 'secondary':
                return 'bg-gray-700';
            case 'info':
                return 'bg-blue-700';
            default:
                return 'bg-red-400';
        }
    }
</script>