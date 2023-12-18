<template>
    <Card>

        <el-menu>

            <!-- LOGO -->
            <el-menu-item index="0">
                <!-- This is a company logo, insid a link, so the image acts like a link -->
                <NavLink
                    href="/"
                >
                    <img
                        src="/images/logo.png"
                        alt="Simplelogistik logo"
                    />
                </NavLink>
            </el-menu-item>

            <!-- DASHBOARD -->
            <el-menu-item index="Dashboard">
                <NavLink
                    href="/dashboard"
                >Dashboard</NavLink>
            </el-menu-item>

            <!-- CARGOORDERS -->
            <el-menu-item 
                index="cargo-orders.index"
            >
                <NavLink
                    href="/cargo-orders"
                >Orders list</NavLink>
            </el-menu-item>

            <!-- CUSTOMERS -->
            <el-menu-item 
                index="customers.index"
            >
                <NavLink
                    href="/customers"
                >Customers list</NavLink>
            </el-menu-item>


            <!-- ADDRESSES -->
            <el-menu-item 
                index="addresses.index"
            >
                <NavLink
                    href="/addresses"
                >Addresses list</NavLink>
            </el-menu-item>
            
            <!-- OTHER -->
            <el-sub-menu
                index="other"
            >
                <template #title>
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

        <el-switch
            v-model="data.isCollapsed"
            :active-action-icon="View"
            :inactive-action-icon="Hide"
        />
    </Card>
</template>

<script setup>
import Card from "./Card.vue";
import NavLink from "./NavLink.vue";
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import { Hide, View } from '@element-plus/icons-vue';

const data = reactive({
    isCollapsed: true,
});

const handleOpen = (key, keyPath) => {
    console.log(key, keyPath)
}
const handleClose = (key, keyPath) => {
    console.log(key, keyPath)
}


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

</style>
