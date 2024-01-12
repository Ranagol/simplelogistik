<template>
    <div @click="toggleSubMenu" class="relative">
        <slot name="header">
            <SidebarMenuItem :flyout="!menuOpen">
                <template #icon><Menu /></template>
                <template #title>Mehr</template>
            </SidebarMenuItem>
        </slot>
        <div :class="{visible: subMenuVisible, hidden: !subMenuVisible, 'flyover-menu': !menuOpen}">
            <slot name="items" />
        </div>
    </div>
</template>

<script setup>
import { Menu } from '@element-plus/icons-vue'
import SidebarMenuItem from './SidebarMenuItem.vue';
</script>
<script>
export default {
    name: 'SidebarSubMenu',
    data() 
    {
        return {
            subMenuVisible: false
        }
    },
    methods: 
    {
        toggleSubMenu() {
            this.subMenuVisible = !!!this.subMenuVisible;
        }
    },
    props: 
    {
        menuOpen: {
            type: Boolean,
            default: false
        }
    },
}
</script>

<style scoped>
    .flyover-menu {
        position: absolute;
        top: 0;
        right: -100px;
        background: white;
        border-radius: 12px;
        padding: 12px;
        z-index: 100;
    }
</style>
