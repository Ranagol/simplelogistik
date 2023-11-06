<template>
    <Card>
        <ul>
            <li>
                <Link href="/login">Login</Link>
            </li>

            <li>
                <Link href="/users">Users</Link>
            </li>

            <li>Random stuff</li>
            <li>Another item</li>
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

        }
    },
    methods: {
    },

});
</script>

<style scoped>

</style>
