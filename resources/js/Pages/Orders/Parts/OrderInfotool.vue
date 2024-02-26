<script setup>
    import Form from '@/Components/Form.vue';
    import _config from '@/config/Pages/Orders/Form/_details';
    defineProps({
        useContent: {
            type: Boolean,
            required: false,
        },
        order: {
            type: Object,
            required: true
        },
        content: {
            type: Object,
            required: false
        }
    });
</script>
<template>
    <Form :content="content" :form="_config" />
</template>
