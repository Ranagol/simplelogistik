<template>

    <Card>
        <h1>Users</h1>

        <ol>
            <li v-for="user in users" :key="user.id">
                {{ user.name }}
            </li>
        </ol>

    </Card>

</template>

<script lang="ts">
import { PropType, defineComponent } from 'vue';
import { User } from '@/types/Models/User';
import Card from '@/Shared/Card.vue';
export default defineComponent({
    components: {
        Card
    },
    props: {
        users: Array as PropType<User[]>
    }
});

</script>
