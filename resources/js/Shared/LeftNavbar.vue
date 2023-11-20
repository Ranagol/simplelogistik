<template>
    <Card>
        <ul>
            <!-- :class... Here we set the background, text, look of the selected nav item
            If we are one the Home page, the Home nav item will be selected, and so on.
            -->
            <!-- <li
                v-for="menuItem in menuItems"
                :key="menuItem.name"
                class="nav_item"
                :class="{ 'selected_nav_item': $page.component === menuItem.path }"
            >
                <NavLink
                    :href="menuItem.url"
                >{{ menuItem.name }}</NavLink>
            </li> -->
        </ul>

        

        <!-- DYNAMIC WITH LOOPING -->
        <el-menu
            @open="handleOpen"
            @close="handleClose"
        >

            <!-- HOME -->
            <el-menu-item index="Home">
                <NavLink
                    href="/"
                >Home</NavLink>
            </el-menu-item>

            <!-- LOGIN -->
            <el-menu-item index="Login">
                <NavLink
                    href="/login"
                >Login</NavLink>
            </el-menu-item>

            <!-- REGISTER -->
            <el-menu-item index="Register">
                <NavLink
                    href="/register"
                >Register</NavLink>
            </el-menu-item>

            <!-- PALMYRA -->
            <el-menu-item index="Palmyra">
                <NavLink
                    href="/palmyra"
                >Palmyra</NavLink>
            </el-menu-item>
            
            <!-- CUSTOMERS -->
            <el-sub-menu
                index="customers"
            >
                <template #title>
                    <span>Customers</span>
                </template>

                <!-- CUSTOMERS INDEX -->
                <el-menu-item 
                    index="customers.index"
                >
                    <NavLink
                        href="/customers"
                    >Customers</NavLink>
                </el-menu-item>
            </el-sub-menu>

            <!-- ADDRESSES -->
            <el-sub-menu
                index="addresses"
            >
                <template #title>
                    <span>Addresses</span>
                </template>

                <!-- ADDRESSES INDEX -->
                <el-menu-item 
                    index="addresses.index"
                >
                    <NavLink
                        href="/addresses"
                    >Addresses</NavLink>
                </el-menu-item>
            </el-sub-menu>

        </el-menu>
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
            
            
        }
    },
    methods: {
        handleOpen(key: string, keyPath: string) {
            console.log('handleOpen');
            console.log(key, keyPath);
        },
        handleClose(key: string, keyPath: string) {
            console.log('handleClose');
            console.log(key, keyPath);
        }
    }
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
