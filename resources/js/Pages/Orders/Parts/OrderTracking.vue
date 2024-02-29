<script setup>
    import Form from '@/Components/Form.vue';
    import _config from '@/config/Pages/Orders/Form/_tracking';
    defineProps({
        useContent: {
            type: Boolean,
            required: false,
        }
    });

    import {store as useStore} from '@/Stores/orderStore';
    let contentStore = useStore();
    let content = contentStore.getOne();
    
</script>
<template>
    <code lang="json"><pre>{{ content }}</pre></code>
</template>
