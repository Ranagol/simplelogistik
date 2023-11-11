<template>
    <Card>
        <ul>
            <li v-for="menuItem in menuItems" :key="menuItem.name" class="nav_item">
                <Link :href="menuItem.url">{{ menuItem.name }}</Link>
            </li>
        </ul>
    </Card>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Card from "./Card.vue";
export default defineComponent({
    name:'LeftNavbar',
    components: {
        Card
    },
    data() {
        return {
            menuItems: [
                { name: 'Home', url: '/' },
                { name: 'Login', url: '/login' },
                { name: 'Register', url: '/register' },
                { name: 'Users', url: '/users' },
                { name: 'First', url: '/first' },
            ] as { name: string, url: string }[]
        }
    },
    methods: {
    },

});
</script>

<style scoped>

.nav_item {
    margin-left: 10px;
    margin-bottom: 10px;
}

</style>
