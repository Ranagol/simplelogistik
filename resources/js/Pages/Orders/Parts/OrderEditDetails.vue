<script setup>
    import Form from '@/Components/Form.vue';
    import _config from '@/config/Pages/Orders/Form/_details';
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
<<<<<<< HEAD
    <Form :content="content" :useData="route().current().includes('edit')" :store="content" :config="_config" :form="_config" />
=======
    <Form :content="content" :useData="route().current().includes('edit')" :store="contentStore" :config="_config" :form="_config" />
>>>>>>> main
</template>
