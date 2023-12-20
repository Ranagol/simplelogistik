<template>
    <el-container>
        <el-container class="set_height">

            <!-- HEADER -->
            <el-header>
                <Header/>
            </el-header>

            <el-container class="pl-5">
                <!-- LEFT NAVBAR -->
                <el-aside width="auto">
                    <LeftNavbar/>
                </el-aside>

                <el-container>

                    <!-- THE WEBPAGE MAIN CONTENT -->
                    <el-main>

                        <!-- SLOT -->
                        <slot />
                    </el-main>

                    <!-- FOOTER -->
                    <el-footer>
                        <Footer/>
                    </el-footer>

                </el-container>
            </el-container>
        </el-container>
    </el-container>
</template>


<script setup>
import { defineComponent } from 'vue';
import { Head } from '@inertiajs/vue3';
import LeftNavbar from './LeftNavbar.vue';
import Header from './Header.vue';
import Footer from './Footer.vue';

</script>

<style scoped>

    /* vh stands for "viewport height" and 100vh is equal to 100% of the height of the viewport. 
    The viewport is the user's visible area of a web page. So, 100vh will cover the entire height 
    of the screen (from the very top to the very bottom), regardless of the screen size.*/
    .set_height {
        min-height: 100vh;
    }
</style>
