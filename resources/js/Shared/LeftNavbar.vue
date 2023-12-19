<template>
    <!-- <Card> -->
        

        <el-menu
            :collapse="data.isCollapsed"
            @open="handleOpen"
            @close="handleClose"
            class="el-menu-vertical-demo set_height"
        >
            <!-- SWITCH -->
            <el-menu-item index="switch">
                <el-switch
                    v-model="data.isCollapsed"
                    :active-action-icon="View"
                    :inactive-action-icon="Hide"
                />
            </el-menu-item>
            

            <!-- LOGO -->
            <!-- This is a company logo, inside a link, so the image acts like a link -->
            <!-- <el-menu-item index="0">
                <NavLink
                    href="/"
                >
                    <img
                        src="/images/logo.png"
                        alt="Simplelogistik logo"
                    />
                </NavLink>
            </el-menu-item> -->

            <!-- DASHBOARD -->
            <el-menu-item index="Dashboard">
                
                <!-- Icon with link -->
                <NavLink
                    href="/dashboard"
                >
                    <el-icon size="50"><Briefcase /></el-icon>
                </NavLink>

                <!-- Text with link -->
                <template #title>
                    <NavLink
                        href="/dashboard"
                    >Dashboard</NavLink>
                </template>
            </el-menu-item>

            <!-- ORDERS -->
            <el-menu-item 
                index="cargo-orders.index"
            >
                <!-- Icon with link -->
                <NavLink
                    href="/cargo-orders"
                >
                    <el-icon size="50"><Box /></el-icon>
                </NavLink>

                <!-- Text with link -->
                <template #title>
                    <NavLink
                        href="/cargo-orders"
                    >Orders</NavLink>
                </template>
            </el-menu-item>

            <!-- CUSTOMERS -->
            <el-menu-item 
                index="customers.index"
            >
                <!-- Icon with link -->
                <NavLink
                    href="/customers"
                >
                    <el-icon size="50"><Avatar /></el-icon>
                </NavLink>

                <!-- Text with link -->
                <template #title>
                    <NavLink
                        href="/customers"
                    >Customers</NavLink>
                </template>
            </el-menu-item>

            <!-- ADDRESSES -->
            <el-menu-item 
                index="addresses.index"
            >
                <!-- Icon with link -->
                <NavLink
                    href="/addresses"
                >
                    <el-icon size="50"><House /></el-icon>
                </NavLink>

                <!-- Text with link -->
                <template #title>
                    <NavLink
                        href="/addresses"
                    >Addresses</NavLink>
                </template>
            </el-menu-item>
            
            <!-- OTHER -->
            <el-sub-menu
                index="other"
            >
                <template #title>
                    <el-icon size="50"><IconMenu /></el-icon>
                    <span>Other</span>
                </template>

                <!-- PAMYRA -->
                <el-menu-item index="Pamyra">
                    <NavLink
                        href="/pamyra"
                    >Pamyra</NavLink>
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

            </el-sub-menu>
        </el-menu>

        

    <!-- </Card> -->
</template>

<script setup>
import Card from "./Card.vue";
import NavLink from "./NavLink.vue";
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import { Hide, View, House, Avatar, Box, Briefcase  } from '@element-plus/icons-vue';
import { Menu as IconMenu, Location, Setting } from '@element-plus/icons-vue'


const data = reactive({
    isCollapsed: false,
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
}

/*
.el-menu-vertical-demo {
    width: 300px;
    min-height: 1200px;
}
*/

/* vh stands for "viewport height" and 100vh is equal to 100% of the height of the viewport. 
The viewport is the user's visible area of a web page. So, 100vh will cover the entire height 
of the screen (from the very top to the very bottom), regardless of the screen size.*/
.set_height {
    min-height: 100vh;
}

</style>
