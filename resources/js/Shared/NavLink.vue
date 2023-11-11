<template>
    <Link class="hover:underline">
        <slot />
    </Link>
</template>

<script>
import { defineComponent } from 'vue';
import { Link } from '@inertiajs/vue3';
export default defineComponent({
    components: { Link },
});
</script>


