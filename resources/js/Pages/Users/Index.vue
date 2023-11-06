<template>
        <h1>Users</h1>

        <ol>
            <li v-for="user in users" :key="user.id">
                {{ user.name }}
            </li>
        </ol>

</template>

<script lang="ts">
import { PropType, defineComponent } from 'vue';
import { User } from '@/types/Models/User';
export default defineComponent({
    props: {
        users: Array as PropType<User[]>
    }
});

</script>
