<template>
    <v-app>
        <v-layout>
            <v-app-bar title="Application bar">
                <Nav />
            </v-app-bar>

            <v-navigation-drawer>
                <v-list>
                    <v-list-item>
                        <Link href="/login">Login</Link>
                    </v-list-item>

                    <v-list-item title="Random stuff"></v-list-item>
                    <v-list-item title="Another item"></v-list-item>
                </v-list>
            </v-navigation-drawer>

            <v-main>
                <!-- SLOT -->
                <slot />
            </v-main>

        </v-layout>
    </v-app>
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
