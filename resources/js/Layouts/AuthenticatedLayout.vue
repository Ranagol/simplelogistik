<script setup lang="ts">
import Header from './../Shared/Header.vue';
import LeftNavbar from './../Shared/LeftNavbar.vue';
import Footer from './../Shared/Footer.vue';
</script>

<template>
  <div class="flex flex-col">
    <section class="flex flex-col relative">
      <aside class="flex flex-row bg-red-50 h-screen fixed top-0" :class="{'menu-open' : menuOpen, 'menu-closed': !menuOpen}">
        <LeftNavbar class="shadow-lg shadow-gray-300" :menuExpanded="menuOpen" />
        <button class="absolute grid place-items-center left-full top-1/2 translate-x-[-50%] translate-y-[-50%] h-9 w-9 rounded-full bg-blue-500 text-white" @click="toggleMenuState">
          <el-icon>
            <ArrowLeftBold v-if="menuOpen" /> 
            <ArrowRightBold v-else/> 
          </el-icon>
        </button>
      </aside>
      <section class="flex flex-col" :class="{'menu-open-content' : menuOpen, 'menu-closed-content': !menuOpen}">
        <main class="w-full mt-20 pr-4">
          <slot />
        </main>
        <footer class="flex">
          <Footer />
        </footer>
      </section>
    </section>
    <header :class="{'menu-open-top-nav' : menuOpen, 'menu-closed-top-nav': !menuOpen}">
      <Header class="w-full right-0 fixed top-0 z-10" />
    </header>
  </div>
</template>

<style lang="scss" type="text/scss" scoped>
    .el-menu {
        border-right: none;
    }
    .el-header {
        --el-header-padding: 0;
    }

    .menu-open {
        width: 250px;
        transition: all 400ms;
        -webkit-transition: all 400ms;
    }

    .menu-closed {
        width: 60px;
        transition: all 400ms;
        -webkit-transition: all 400ms;
    }

    .menu-open-top-nav {
        width: calc(100% - 250px);
        right: 0;
        position: absolute;
        transition: all 400ms;
        -webkit-transition: all 400ms;
    }

    .menu-closed-top-nav {
        width: calc(100% - 60px);
        right: 0;
        position: absolute;
        transition: all 400ms;
        -webkit-transition: all 400ms;
    }
    
    .menu-open-content {
        width: calc(100% - 250px - 20px);
        right: 0;
        position: absolute;
        transition: all 400ms;
        -webkit-transition: all 400ms;
    }

    .menu-closed-content {
        width: calc(100% - 60px - 20px);
        right: 0;
        position: absolute;
        transition: all 400ms;
        -webkit-transition: all 400ms;
    }

</style>

<script lang="ts">
const savedState = sessionStorage.getItem('menuOpen') === "true" ? true : false;
const menuOpen = ref(savedState);

const toggleMenuState = () => {
  menuOpen.value = !!!menuOpen.value;
  sessionStorage.setItem('menuOpen', menuOpen.value === true ? "true" : "false");
}

import { defineProps, defineEmits, ref } from 'vue';
import { ArrowLeftBold, ArrowRightBold } from '@element-plus/icons-vue';

export default {
    data () {
        return {
          menuExpanded: false
        }
    }
}

</script>