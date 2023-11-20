<template>
    <Card>
        <ul>
            <!-- :class... Here we set the background, text, look of the selected nav item
            If we are one the Home page, the Home nav item will be selected, and so on.
            -->
            <li
                v-for="menuItem in menuItems"
                :key="menuItem.name"
                class="nav_item"
                :class="{ 'selected_nav_item': $page.component === menuItem.path }"
            >
                <NavLink
                    :href="menuItem.url"
                >{{ menuItem.name }}</NavLink>
            </li>
        </ul>
    </Card>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Card from "./Card.vue";
import NavLink from "./NavLink.vue";
export default defineComponent({
    components: {
        Card,
        NavLink
    },
    data() {
        return {
            menuItems: [
                { name: 'Home', path: 'Home', url: '/' },
                { name: 'Login', path: 'Login', url: '/login' },
                { name: 'Register', path: 'Register', url: '/register' },
                { name: 'Users', path: 'Users/Index', url: '/users' },
                // { name: , path: 'First', url: '/first' },
                { name: 'Pamyra', path: 'Pamyra', url: '/pamyra' },
                { name: 'Customers', path: 'Customers/Index', url: '/customers' },
                { name: 'Cargo orders', path: 'CargoOrders/Index', url: '/cargo-orders' },
                { name: 'Addresses', path: 'Addresses/Index', url: '/addresses' },
            ] as { name: string, url: string, path: string }[]
        }
    },
});
</script>

<style scoped>

/**
 * Style of all navigation items.
 */
.nav_item {
    padding: 5px;
    padding-left: 15px;
}

.selected_nav_item{
    background-color: var(--primary);
    font-weight: bold;
    color: white;
    border-radius: 6.4px;
    /*box-shadow: 0 1px 3px #7367F0;*/
}

</style>
