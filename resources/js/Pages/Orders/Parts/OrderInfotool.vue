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
    <div>
        <Form :content="content" :config="_config" :form="_config" />
    </div>
</template>
