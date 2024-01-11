<template>
    <el-menu style="position: sticky !important; top: 10px !important"
    :collapse="isCollapse"
    @open="handleOpen"
    @close="handleClose"
    >
    <el-sub-menu index="1">
        <template #title>
        <el-icon><location /></el-icon>
        <span>Navigator One</span>
        </template>
        <el-menu-item-group>
        <template #title><span>Group One</span></template>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-1">{{ $t("menu.left.dashboard") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-2">{{ $t("menu.left.orders") }}</el-menu-item>
        </el-menu-item-group>
        <el-menu-item-group title="Group Two">
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-3">{{ $t("menu.left.customers") }}</el-menu-item>
        </el-menu-item-group>
        <el-sub-menu index="1-4">
            <template #title><span>item four</span></template>
            <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="1-4-1">{{ $t("menu.left.addresses") }}</el-menu-item>
        </el-sub-menu>
    </el-sub-menu>
    <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="2">
        <el-icon><icon-menu /></el-icon>
        <template #title>Navigator Two</template>
    </el-menu-item>
    <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="3">
        <el-icon><document /></el-icon>
        <template #title>Navigator Three</template>
    </el-menu-item>
    <el-menu-item @click="saveCurrentLocation('dashboard')" :class="isActive('dashboard')" index="4">
        <el-icon><setting /></el-icon>
        <template #title>Navigator Four</template>
    </el-menu-item>
    </el-menu>
    <el-button v-model="isCollapse" @click="isCollapse = !!!isCollapse">
        <el-icon>
            <ArrowRight v-if="isCollapse" />
            <ArrowLeft v-else />
        </el-icon>
    </el-button>
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
  } from '@element-plus/icons-vue'
  
  const saveCurrentLocation = (loc: string) => {
    sessionStorage.setItem('currentLocation', loc)
  }

  const isActive = (loc: string) => {
    return sessionStorage.getItem('currentLocation') === loc ? "active" : ""
  }

  const isCollapse = ref(sessionStorage.getItem('menuStateOpen') === 'true')
  const handleOpen = (key: string, keyPath: string[]) => {
    sessionStorage.setItem('menuStateOpen', "true")
  }
  const handleClose = (key: string, keyPath: string[]) => {
    sessionStorage.setItem('menuStateOpen', "false")
  }
  </script>
