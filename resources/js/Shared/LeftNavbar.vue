<template>
    <Card>

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

            <!-- REGISTER -->
            <el-menu-item index="Experiment">
                <NavLink
                    href="/experiments"
                >Experiment</NavLink>
            </el-menu-item>

            <!-- PALMYRA -->
            <el-menu-item index="Pamyra">
                <NavLink
                    href="/pamyra"
                >Pamyra</NavLink>
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
                    >Customers list</NavLink>
                </el-menu-item>

                <!-- JUST FOR TEMPORARY DISPLAY -->
                <el-menu-item 
                    index="111"
                >
                    <NavLink
                        href="/random"
                    >Just temporary</NavLink>
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
                    >Addresses list</NavLink>
                </el-menu-item>

                <!-- JUST FOR TEMPORARY DISPLAY -->
                <el-menu-item 
                    index="222"
                >
                    <NavLink
                        href="/random"
                    >Just temporary</NavLink>
                </el-menu-item>
            </el-sub-menu>

            <!-- VEHICLES -->
            <el-sub-menu
                index="vehicles"
            >
                <template #title>
                    <span>Vehicles</span>
                </template>

                <el-menu-item 
                    index="vehicles.index"
                >
                    <NavLink
                        href="/vehicles"
                    >Vehicles list</NavLink>
                </el-menu-item>

                <!-- JUST FOR TEMPORARY DISPLAY -->
                <el-menu-item 
                    index="222"
                >
                    <NavLink
                        href="/random"
                    >Just temporary</NavLink>
                </el-menu-item>
            </el-sub-menu>

            <!-- REQUIREMENTS -->
            <el-sub-menu
                index="requirements"
            >
                <template #title>
                    <span>Requirements</span>
                </template>

                <!-- ADDRESSES INDEX -->
                <el-menu-item 
                    index="requirements.index"
                >
                    <NavLink
                        href="/requirements"
                    >Requirements list</NavLink>
                </el-menu-item>

                <!-- JUST FOR TEMPORARY DISPLAY -->
                <el-menu-item 
                    index="222"
                >
                    <NavLink
                        href="/random"
                    >Just temporary</NavLink>
                </el-menu-item>
            </el-sub-menu>

            <!-- CARGOORDERS -->
            <el-sub-menu
                index="cargo-orders"
            >
                <template #title>
                    <span>Cargo orders list</span>
                </template>

                <!-- CARGOORDERS INDEX -->
                <el-menu-item 
                    index="cargo-orders.index"
                >
                    <NavLink
                        href="/cargo-orders"
                    >Cargo orders</NavLink>
                </el-menu-item>

                <!-- JUST FOR TEMPORARY DISPLAY -->
                <el-menu-item 
                    index="333"
                >
                    <NavLink
                        href="/random"
                    >Just temporary</NavLink>
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
            // console.log('handleOpen');
            // console.log(key, keyPath);
        },
        handleClose(key: string, keyPath: string) {
            // console.log('handleClose');
            // console.log(key, keyPath);
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
}

</style>
