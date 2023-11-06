<template>
    <Nav />

    <ul>
        <li>
            <Link href="/login">Login</Link>
        </li>

        <li>
            <Link href="/users">Users</Link>
        </li>

        <li title="Random stuff"></li>
        <li title="Another item"></li>
    </ul>

    <main>
        <!-- SLOT -->
        <slot />
    </main>

</template>

<script lang="ts">
import Nav from "./Nav.vue";
import { Head } from '@inertiajs/vue3';

export default {
    components: { Nav, Head },

    computed: {
        username() {

            /**
             * This data is set and send from app\Http\Middleware\HandleInertiaRequests.php, share().
             */
            // return this.$page.props.auth.user.username;
        }
    }
};

</script>
