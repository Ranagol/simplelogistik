<template>
    <Card class="flex flex-row justify-between">

        <!-- THE LOGO IMAGE -->
        <div>
            <NavLink
                href="/"
            >
                <img
                    width="200"
                    src="/images/logo.png"
                    alt="Simplelogistik logo"
                />
            </NavLink>

        </div>
        
        <!-- WELCOME, USER -->
        <div class="flex flex-row justify-end">
            <span
                v-if="username"
                class="mr-7"
            >Welcome, {{ username }}</span>

            <!-- Jeff did here a bit of an unnecesary complication. NavLink is a wrapper around the
            Inertia Link component, so for some magical reason we can here use NavLink as if it were
            the Link component. And the Link component can send request, can work with get/post/etc
            methods. -->
            <NavLink href="/logout" method="post" as="button">
                Logout
            </NavLink>
        </div>
    </Card>
</template>

<script>
import NavLink from "./NavLink.vue";
import { defineComponent } from 'vue';
import Card from "./Card.vue";
export default defineComponent({
    components: {
        NavLink,
        Card
    },
    computed: {
        username() {

            /**
             * This data is set and send from app\Http\Middleware\HandleInertiaRequests.php, share().
             */
            return this.$page?.props?.auth?.user?.name;
        }
    },
});
</script>

<style scoped>

</style>
