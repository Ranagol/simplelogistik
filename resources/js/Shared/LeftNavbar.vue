<template>
  <div class="flex flex-col h-full w-full overflow-y-scroll overflow-x-hidden hide-scrollbar bg-white px-3 pt-20">
    <div class="w-full my-3 overflow-x-hidden text-white flex">
      <Link class="hoverable grid place-items-center grid-flow-col" :href="route('dashboard')">
        <el-icon class="ml-1" size="30" color="black">
          <Histogram></Histogram>
        </el-icon>
        <span class="text-black flex pl-1">{{ $t("menu.dashboard") }}</span>
      </Link>
    </div>
    <div class="w-full my-3 overflow-x-hidden text-white flex">
      <Link class="hoverable grid place-items-center grid-flow-col" :href="route('addresses.index')">
        <el-icon class="ml-1" size="30" color="black">
          <Memo></Memo>
        </el-icon>
        <span class="text-black flex pl-1">{{ $t("menu.addresses") }}</span>
      </Link>
    </div>
    <div class="w-full my-3 overflow-x-hidden text-white flex">
      <Link class="hoverable grid place-items-center grid-flow-col" :href="route('orders.index')">
        <el-icon class="ml-1" size="30" color="black">
          <Folder></Folder>
        </el-icon>
        <span class="text-black flex pl-1">{{ $t("menu.orders") }}</span>
      </Link>
    </div>
    <div class="w-full my-3 overflow-x-hidden text-white flex">
      <Link class="hoverable grid place-items-center grid-flow-col" :href="route('customers.index')">
        <el-icon class="ml-1" size="30" color="black">
          <UserFilled></UserFilled>
        </el-icon>
        <span class="text-black flex pl-1">{{ $t("menu.customers") }}</span>
      </Link>
    </div>
    <div class="w-full my-3 overflow-x-hidden text-white flex flex-col">
      <div @click="toggleSubMenu" class="hoverable grid place-items-center justify-start grid-flow-col cursor-pointer">
        <el-icon class="ml-1" size="30" color="black">
          <IconMenu></IconMenu>
        </el-icon>
        <span class="text-black flex pl-1">{{ $t("menu.integrations") }}</span>
        <el-icon class="ml-1" size="15" color="black">
          <ArrowDown></ArrowDown>
        </el-icon>
      </div>
      <div class="submenu-floating pl-8 pt-2 overflow-y-hidden" :class="{'subMenuVisible': submenuOpen, 'subMenuHidden': !submenuOpen}">
        <div class="w-full my-3 overflow-x-hidden text-white flex">
          <Link class="hoverable grid place-items-center grid-flow-col" :href="route('dashboard')">
            <el-icon class="ml-1" size="30" color="black">
              <Location></Location>
            </el-icon>
            <span class="text-black flex pl-1">{{ $t("menu.pamyra") }}</span>
          </Link>
        </div>
      </div>
    </div>
  </div>  
</template>
  
<script lang="ts" setup>
  import { ref } from 'vue'
  import { Memo, User as UserFilled, Histogram, Folder, Menu as IconMenu, Location, ArrowDown } from '@element-plus/icons-vue';
</script>

<script lang="ts">
  const submenuOpen = ref(false);
  function toggleSubMenu(){
    submenuOpen.value = !!!submenuOpen.value;
  }
</script>

<style scoped>
  .hoverable:hover * {
    color: rgb(59, 130, 246)
  }
  .subMenuVisible {
    max-height: 1000px;
    transition: max-height 4000ms;
  }
  .subMenuHidden {
    max-height: 1px;
    transition: max-height 800ms;
  }

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
