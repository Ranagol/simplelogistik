<script setup lang="ts">
import Header from './../Shared/Header.vue';
import LeftNavbar from './../Shared/LeftNavbar.vue';
import Footer from './../Shared/Footer.vue';
</script>

<template>
    <div class="common-layout">
      <el-container>
        <el-header><Header/></el-header>
        <el-container>
          <el-aside class="flex"><LeftNavbar class="w-full"/></el-aside>
          <el-container>
            <el-main><slot/></el-main>
            <el-footer><Footer/></el-footer>
          </el-container>
        </el-container>
      </el-container>
    </div>
  </template>

<style lang="scss" type="text/scss" scoped>
    .el-menu {
        border-right: none;
    }
    .el-header {
        --el-header-padding: 0;
    }
</style>