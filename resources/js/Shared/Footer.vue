<template>
    <footer class="footer-content-container">

        <div
            class="flex-row"
        > © {{ data.currentYear }}, Simplelogistik GmbH. All rights reserved.</div>

    </footer>
</template>

<script setup>
import { reactive, computed, watch, onMounted, nextTick, ref } from 'vue';

const data = reactive({
    //counts automatiaclly the current year for the copyright section
    currentYear: new Date().getFullYear()
});
</script>

<style scoped></style>
