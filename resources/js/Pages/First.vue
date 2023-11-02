<template>
    <div>
        <h1>First Page</h1>
    </div>
    <div>
        <Second />
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
// import Second from './Second.vue';
import Second from '@/Pages/Second.vue';//TODO importing component with @ is not working.
//TODO why is Telescope not working? http://127.0.0.1:8000/telescope
export default defineComponent({
    components: {
        Second,
    },
});

</script>
