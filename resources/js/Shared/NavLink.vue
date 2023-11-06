<template>
    <Link class="text-black hover:underline" :class="{ 'font-bold underline': active }">
        <slot />
    </Link>
</template>

<script>
import { defineComponent } from 'vue';
import { Link } from '@inertiajs/vue3';
export default defineComponent({
    components: { Link },
    props: {
        active: Boolean
    }
});
</script>

<style scoped>

</style>

