<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <!-- Navbar -->
        <Navbar />

        <!-- Sidebar -->
        <Sidebar />

        <main class="p-4 md:ml-64 h-screen pt-20">
            <div class="rounded-lg h-auto mb-4">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>

import Navbar from '@/Components/Navbar/Navbar.vue';
import Sidebar from '@/Components/Sidebar/Sidebar.vue';
import { initFlowbite } from 'flowbite';
import { onMounted } from 'vue';

onMounted(() => {
    initFlowbite();
})

</script>
