<template>
    <Head title="First" />
    <Card>
        <div>
            <h1>First Page</h1>
        </div>
        <div>
            <Second />
        </div>

        <el-input v-model="text" class="experiment"/>

        <el-button  type="primary">Primary</el-button>
    </Card>

</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Second from '@/Pages/Second.vue';
import Card from "@/Shared/Card.vue";
export default defineComponent({
    components: {
        Second,
        Card,
    },
    props: {
    },
    data() {
        return {
            text: 'Hello World' as string,
        }
    }
});

</script>
