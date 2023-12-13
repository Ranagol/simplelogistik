<template>
    <Card>

        <el-menu>

            <!-- DASHBOARD -->
            <el-menu-item index="Dashboard">
                <NavLink
                    href="/dashboard"
                >Dashboard</NavLink>
            </el-menu-item>

            <!-- CARGOORDERS -->
            <!-- <el-sub-menu
                index="cargo-orders"
            >
                <template #title>
                    <span>Orders</span>
                </template> -->

                <!-- CARGOORDERS INDEX -->
                <el-menu-item 
                    index="cargo-orders.index"
                >
                    <NavLink
                        href="/cargo-orders"
                    >Orders list</NavLink>
                </el-menu-item>

            <!-- </el-sub-menu> -->

            <!-- CUSTOMERS -->
            <!-- <el-sub-menu
                index="customers"
            >
                <template #title>
                    <span>Customers</span>
                </template> -->

                <!-- CUSTOMERS INDEX -->
                <el-menu-item 
                    index="customers.index"
                >
                    <NavLink
                        href="/customers"
                    >Customers list</NavLink>
                </el-menu-item>

            <!-- </el-sub-menu> -->

            <!-- ADDRESSES -->
            <!-- <el-sub-menu
                index="addresses"
            >
                <template #title>
                    <span>Addresses</span>
                </template> -->

                <!-- ADDRESSES INDEX -->
                <el-menu-item 
                    index="addresses.index"
                >
                    <NavLink
                        href="/addresses"
                    >Addresses list</NavLink>
                </el-menu-item>

            <!-- </el-sub-menu> -->
            
            <!-- OTHER -->
            <el-sub-menu
                index="other"
            >
                <template #title>
                    <span>Other</span>
                </template>

                <!-- VEHICLES -->
                <!-- <el-menu-item 
                    index="vehicles.index"
                >
                    <NavLink
                        href="/vehicles"
                    >Vehicles list</NavLink>
                </el-menu-item> -->

                <!-- REQUREMENTS -->
                <!-- <el-menu-item 
                    index="requirements.index"
                >
                    <NavLink
                        href="/requirements"
                    >Requirements list</NavLink>
                </el-menu-item> -->

                <!-- PALMYRA -->
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
    </Card>
</template>

<script lang="ts" setup>
import { defineComponent } from 'vue';
import Card from "./Card.vue";
import NavLink from "./NavLink.vue";



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
