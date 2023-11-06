<template>
    <Card>
        <ul>
            <li v-for="menuItem in menuItems" :key="menuItem.name">
                <Link :href="menuItem.url">{{ menuItem.name }}</Link>
            </li>
        </ul>
    </Card>
</template>

<script lang="ts">
import { defineComponent } from 'vue';//TODO how to solve this error that is not an error, only TS is making trouble
import Card from "./Card.vue";
export default defineComponent({
    name:'LeftNavbar',
    components: {
        Card
    },
    data() {
        return {
            menuItems: [//TODO how to solve this TS issue? Red undelrine in the rendered html...
                { name: 'Home', url: '/' },
                { name: 'About', url: '/about' },
                { name: 'Contact', url: '/contact' },
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

</style>
