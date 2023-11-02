<template>
    <v-app>
        <h1>Users</h1>

        <v-list>
            <v-list-item v-for="user in users" :key="user.id">
                <v-list-item-title>{{ user.name }}</v-list-item-title>
            </v-list-item>
        </v-list>

    </v-app>
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
