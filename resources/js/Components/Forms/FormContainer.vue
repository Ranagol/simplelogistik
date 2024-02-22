<script setup>
import FormField from '@/Components/Forms/FormField.vue';

defineProps({
    config: {
        type: Object,
        required: true
    }
});

</script>

<template>
    <span class="relative block p-4 px-0 font-bold text-[17px]">{{ $t(config.title) }}</span>
    <div class="grid grid-cols-12 gap-4">
        <FormField v-for="field in config.fields" :fieldConfig="field" />
    </div>
</template>