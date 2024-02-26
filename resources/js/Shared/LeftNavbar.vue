<template>
  <div class="h-full transition-all duration-[300ms] custom-scroll" :class="{'max-w-[70px]': !menuOpen, 'max-w-[180px]': menuOpen}">
    <!-- Menu Item -->
    <SidebarMenuItem iconSize="26" :menuOpen="menuOpen" toolTipText="menu.dashboard" link="/dashboard">
      <template #icon><Histogram /></template>
      <template #title>{{ $t('menu.dashboard') }}</template>
    </SidebarMenuItem>
    <!-- Menu Item End -->

    <!-- Menu Item -->
    <SidebarMenuItem iconSize="26" :menuOpen="menuOpen" toolTipText="menu.orders" link="/orders">
      <template #icon><Folder /></template>
      <template #title>{{ $t('menu.orders') }}</template>
    </SidebarMenuItem>
    <!-- Menu Item End -->

    <!-- Menu Item -->
    <SidebarMenuItem iconSize="26" :menuOpen="menuOpen" toolTipText="menu.customers" link="/customers">
      <template #icon><UserFilled /></template>
      <template #title>{{ $t('menu.customers') }}</template>
    </SidebarMenuItem>
    <!-- Menu Item End -->
 
    <!-- Menu Item -->
    <SidebarMenuItem iconSize="26" :menuOpen="menuOpen" toolTipText="menu.addresses" link="/addresses">
      <template #icon><Memo /></template>
      <template #title>{{ $t('menu.addresses') }}</template>
    </SidebarMenuItem>
    <!-- Menu Item End -->

    <!-- Sub Menu -->
    <SidebarSubMenu :menuOpen="menuOpen">
      <template #header>
        <!-- Submenu displayed "Title" -->
        <SidebarMenuItem :menuOpen="menuOpen" iconSize="26" link="#">
          <template #icon><IconMenu /></template>
          <template #title>{{ $t('menu.integrations') }}</template>
        </SidebarMenuItem>
      </template>
      <!-- Submenu title End -->
      <!-- Submenu Items -->
      <template #items>
        <SidebarMenuItem iconSize="26" :menuOpen="menuOpen" toolTipText="menu.pamyra" link="/pamyra">
          <template #icon><Location /></template>
          <template #title>{{ $t('menu.pamyra') }}</template>
        </SidebarMenuItem>
      </template>
      <!-- Submenu Items End -->
    </SidebarSubMenu>
    <!-- Sub Menu End -->

    <!-- Sidebar State Toggle Button -->
    <button class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2 p-2 bg-blue-400 rounded-full h-10 w-10 grid place-items-center text-white" @click="toggleSidebar">
      <el-icon size="20">
        <ArrowLeft v-if="menuOpen" />
        <ArrowRight v-else />
      </el-icon>
    </button>
    <!-- Sidebar State Toggle Button End -->
  </div>
</template>
  
<script lang="ts" setup>
  import { ref, defineProps} from 'vue'
  import { Memo, User as UserFilled, Histogram, Folder, Menu as IconMenu, Location, ArrowRight, ArrowLeft } from '@element-plus/icons-vue';
  import SidebarMenuItem from '@/Components/SidebarMenuItem.vue';
  import SidebarSubMenu from '@/Components/SidebarSubMenu.vue';
  
  const props = defineProps({
    method: Function
  });  

  const menuOpen = ref(false);
  function toggleSidebar(){
    props.method(!!!menuOpen.value);
    menuOpen.value = !!!menuOpen.value;
  }
</script>

<style scoped>
  .custom-scroll::-webkit-scrollbar {
    display: none;
  }
</style>