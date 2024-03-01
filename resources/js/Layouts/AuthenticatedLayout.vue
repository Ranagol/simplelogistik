<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <!-- Navbar -->
        <Navbar />

        <!-- Sidebar -->
        <Sidebar />

        <main class="h-screen p-4 pt-20 md:ml-64">
            <div class="h-auto mb-4 rounded-lg">
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
