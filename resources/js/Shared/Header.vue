<template>
    <div class="component-background p-5 card-border">

        <!-- Jeff did here a bit of an unnecesary complication. NavLink is a wrapper around the
        Inertia Link component, so for some magical reason we can here use NavLink as if it were
        the Link component. And the Link component can send request, can work with get/post/etc
        methods. -->
        <NavLink href="/logout" method="post" as="button">
            Log Out
        </NavLink>

    </div>

</template>

<script>
import NavLink from "./NavLink.vue";
import { defineComponent } from 'vue';
export default defineComponent({
    components: { NavLink },
});
</script>

<style scoped>

.card-border {
    border: none;
}

</style>
