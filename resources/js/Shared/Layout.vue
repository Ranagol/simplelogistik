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
import { defineComponent } from 'vue';
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
    computed: {
        username() {

            /**
             * This data is set and send from app\Http\Middleware\HandleInertiaRequests.php, share().
             */
            // return this.$page.props.auth.user.username;
        }
    },
    methods: {
    },

});
</script>

<style scoped>
    .set-height {
        min-height: 58rem;
    }
</style>
