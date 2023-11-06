<template>
    <el-container>

        <!-- LEFT NAVBAR -->
        <el-aside width="15%" >
            <LeftNavbar/>
        </el-aside>

        <!-- THE WEBPAGE -->
        <el-container class="ml-5 mr-5 set-height">

            <!-- HEADER -->
            <el-header>
                <Header/>
            </el-header>

            <!-- MAIN -->
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
</template>


<script lang="ts">
import { defineComponent } from 'vue';//Cannot find module 'vue' or its corresponding type declarations.ts(2307)
import { useCounterStore } from '@/stores/counter';
import { Head } from '@inertiajs/vue3';//TODO how to solve this error that is not an error, only TS is making trouble
import LeftNavbar from './LeftNavbar.vue';
import Header from './Header.vue';
import Footer from './Footer.vue';
// import Nav from "./Nav.vue";
export default defineComponent({
    name:'Layout',
    components: {
        Head,
        LeftNavbar,
        Header,
        Footer
    },
    data() {
        return {

        }
    },
    methods: {
    },

});
</script>

<style scoped>
    .set-height {
        /**
         * http://127.0.0.1:8000/users - the component with users should fill the page
         */
        min-height: 58rem;/* TODO this is a hack, find a better solution */

    }
</style>
