<template>

    <el-menu
        :collapse="data.isCollapsed"
        @open="handleOpen"
        @close="handleClose"
        class="set_height pl-5 relative-container"
    >

        <!-- SWITCH -->

            <el-button
                type="primary"
                size="small"
                :icon="bla"
                @click="data.isCollapsed = !data.isCollapsed"
                circle
                class="absolute-button"
            >
                <!-- We display ArrowLeft icon or ArrowRight icon depending if the el-menu is 
                collapsed or expanded. -->
                <el-icon
                    v-if="!data.isCollapsed"
                >
                    <ArrowLeft />
                </el-icon>
                <el-icon
                    v-else
                >
                    <ArrowRight />
                </el-icon>
            </el-button>


        <!-- DASHBOARD -->
        <el-menu-item index="Dashboard">
            
            <!-- Icon with link -->
            <NavLink
                href="/dashboard"
            >
                <el-icon size="40" :color="data.iconColor"><Histogram /></el-icon>
            </NavLink>

            <!-- Text with link -->
            <template #title>
                <NavLink
                    href="/dashboard"
                    class="ml-1 mr-7"
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
                <el-icon size="40"  :color="data.iconColor"><Folder /></el-icon>
            </NavLink>

            <!-- Text with link -->
            <template #title>
                <NavLink
                    href="/cargo-orders"
                    class="ml-1"
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
                <el-icon size="40" :color="data.iconColor"><UserFilled /></el-icon>
            </NavLink>

            <!-- Text with link -->
            <template #title>
                <NavLink
                    href="/customers"
                    class="ml-1"
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
                <el-icon size="40" :color="data.iconColor" class="no-inherit"><Memo /></el-icon>
            </NavLink>

            <!-- Text with link -->
            <template #title>
                <NavLink
                    class="ml-1"
                    href="/addresses"
                >Addresses</NavLink>
            </template>
        </el-menu-item>
        
        <!-- OTHER -->
        <el-sub-menu
            index="other"
        >
            <template #title>
                <el-icon size="40"><IconMenu /></el-icon>
                <span>Other</span>
            </template>

            <!-- PAMYRA -->
            <el-menu-item index="Pamyra">
                <NavLink
                    href="/pamyra"
                    class="ml-1"
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

</template>

<script setup>
import Card from "./Card.vue";
import NavLink from "./NavLink.vue";
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import { Memo, UserFilled, Histogram, Folder, ArrowLeft, ArrowRight } from '@element-plus/icons-vue';
import { Menu as IconMenu, Location, Setting } from '@element-plus/icons-vue'


const data = reactive({

    /**
     * Whether the menu is collapsed or not. This is currently controlled by an el-switch.
     */
    isCollapsed: true,

    // iconColor: '#6B7280'
    iconColor: '#FF0000'

    
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
.set_height {
    /* We want the navbar to fill  the whole hight of the available space. */
    height: 100% !important;
}

.relative-container {
    position: relative;
}

.absolute-button {
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
}

</style>
