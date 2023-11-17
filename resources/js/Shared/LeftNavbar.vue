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
                :class="{ 'selected_nav_item': $page.component === menuItem.name }"
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
                { name: 'Home', url: '/' },
                { name: 'Login', url: '/login' },
                { name: 'Register', url: '/register' },
                { name: 'Users/Index', url: '/users' },
                { name: 'First', url: '/first' },
                { name: 'Pamyra', url: '/pamyra' }
            ] as { name: string, url: string }[]
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
    background-color: rgb(115, 103, 240);
    font-weight: bold;
    color: white;
    border-radius: 6.4px;
    box-shadow: 0 1px 3px #7367F0;
}

</style>
