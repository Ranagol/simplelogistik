<template>

    <el-menu
        :collapse="data.isCollapsed"
        @open="handleOpen"
        @close="handleClose"
        class="set_height pl-5 relative_container"
    >

        <!-- SWITCH FOR COLLAPSING/EXPANDING THE el-menu -->
        <el-button
            type="primary"
            size="small"
            :icon="bla"
            @click="data.isCollapsed = !data.isCollapsed"
            circle
            class="absolute_button"
        >
            <!-- We display ArrowLeft icon or ArrowRight icon depending if the el-menu is 
            collapsed or expanded. Now, in order for this button stay always on the right
            edge/in the middle of the el-menu, the css class 'absolute_button' and 'relative
            container' are mandatory. This will keep the el-button in the middle of the right 
            side of the el-menu regardless of whether the el-menu is collapsed or expanded.-->
            <el-icon>
                <ArrowLeft 
                    v-if="!data.isCollapsed"
                />
                <ArrowRight 
                    v-else
                />
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
            index="orders.index"
        >
            <!-- Icon with link -->
            <NavLink
                href="/orders"
            >
                <el-icon size="40"  :color="data.iconColor"><Folder /></el-icon>
            </NavLink>

            <!-- Text with link -->
            <template #title>
                <NavLink
                    href="/orders"
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
import { Menu as IconMenu, Location, Setting } from '@element-plus/icons-vue';


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

/*
The relative_container class is added to the el-menu to make it a relative container.
*/
.relative_container {
    position: relative;
}

/*
This class positions the el-button absolutely within the el-menu.
The top: 50%; and transform: translateY(-50%); styles vertically center the el-button within the 
el-menu.
The right: 0; style places the el-button on the right side of the el-menu.
*/
.absolute_button {
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
}

</style>
