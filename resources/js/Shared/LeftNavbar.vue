<template>
  <div class="flex flex-col h-full w-full overflow-y-scroll overflow-x-hidden hide-scrollbar bg-white px-3 pt-20">
    <div class="w-full my-3 overflow-x-hidden text-white flex">
      <Link class="grid place-items-center grid-flow-col" :href="route('dashboard')">
        <el-icon class="ml-1" size="30" color="black">
          <IconMenu></IconMenu>
        </el-icon>
        <span class="text-black flex pl-1">{{ $t("menu.dashboard") }}</span>
      </Link>
    </div>
    <div class="w-full my-3 overflow-x-hidden text-white flex">
      <Link class="grid place-items-center grid-flow-col" :href="route('addresses.index')">
        <el-icon class="ml-1" size="30" color="black">
          <UserFilled></UserFilled>
        </el-icon>
        <span class="text-black flex pl-1">{{ $t("menu.addresses") }}</span>
      </Link>
    </div>
    <div class="w-full my-3 overflow-x-hidden text-white flex">
      <Link class="grid place-items-center grid-flow-col" :href="route('orders.index')">
        <el-icon class="ml-1" size="30" color="black">
          <Document></Document>
        </el-icon>
        <span class="text-black flex pl-1">{{ $t("menu.orders") }}</span>
      </Link>
    </div>
    <div class="w-full my-3 overflow-x-hidden text-white flex">
      <Link class="grid place-items-center grid-flow-col" href="#">
        <el-icon class="ml-1" size="30" color="black">
          <Location></Location>
        </el-icon>
        <span class="text-black flex pl-1">{{ $t("menu.more") }}</span>
      </Link>
    </div>
  </div>  
</template>
  
<script lang="ts" setup>
  import { ref } from 'vue'
  import {
    ArrowRight,
    ArrowLeft,
    Document,
    Menu as IconMenu,
    Location,
    Setting,
    User,
    UserFilled
  } from '@element-plus/icons-vue'

</script>

<style scoped>
  /* Hide scrollbar for Chrome, Safari and Opera */
  .hide-scrollbar::-webkit-scrollbar {
    display: none;
  }

  /* Hide scrollbar for IE, Edge and Firefox */
  .hide-scrollbar {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
  }
</style>
