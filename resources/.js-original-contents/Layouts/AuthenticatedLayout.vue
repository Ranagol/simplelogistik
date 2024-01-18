<script setup lang="ts">
import Header from './../Shared/Header.vue';
import LeftNavbar from './../Shared/LeftNavbar.vue';
import Footer from './../Shared/Footer.vue';
import { ref } from 'vue';
</script>

<template>
  <div class="flex flex-col">
    <section class="flex flex-col relative">
      <aside class="flex flex-row z-40 bg-white h-screen fixed top-16" >
        <LeftNavbar class="shadow-lg shadow-gray-300 p-4" :method="handleMenu"/>
      </aside>
      <section class="flex flex-col" :class="{'menu-open-content': menuVisible, 'menu-closed-content': !menuVisible}">
        <main class="w-full mt-20 pr-4">
          <slot />
        </main>
        <footer class="flex">
          <Footer />
        </footer>
      </section>
    </section>
    <header >
      <Header class="w-full right-0 fixed top-0 z-10" />
    </header>
  </div>
</template>

<style lang="scss" type="text/scss" scoped>
.menu-open-content {
  width: calc(100% - 70px - 250px);
  position: absolute;
  right: 0;
}
.menu-closed-content {
  width: calc(100% - 70px);
  position: absolute;
  right: 0;
}
</style>

<script lang="ts">
  const menuVisible = ref(false);
  const handleMenu = (menuVisible) => {
    
  }
</script>