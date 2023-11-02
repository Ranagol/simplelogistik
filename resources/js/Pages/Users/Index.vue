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
import User from '@/types/Models/User';//TODO how to set the @ for import path in vitest.config?
export default defineComponent({//TODO why is Telescope not working? http://127.0.0.1:8000/telescope
    props: {
        users: Array as PropType<User[]>
    }
});

</script>
