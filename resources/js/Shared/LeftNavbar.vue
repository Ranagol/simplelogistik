<template>
    <div class="component-background p-5">
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
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
export default defineComponent({
    name:'LeftNavbar',
    components: {
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
