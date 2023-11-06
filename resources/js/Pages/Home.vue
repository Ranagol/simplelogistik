<template>
    <Head title="Home" />

    <Card>
        <h1>Home</h1>
    </Card>
</template>

<script lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { defineComponent } from 'vue';
import Card from '@/Shared/Card.vue';
export default defineComponent({
    components: {
        Head,
        Card
    },
});



</script>

<style>

</style>
