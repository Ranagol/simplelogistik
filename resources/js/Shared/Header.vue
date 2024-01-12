<template>
    <nav data-role="main-navigation" role="navigation" class="hidden md:flex md:flex-row align-middle justify-between bg-white p-4">
        <div data-role="navigation-brand">
            <Link href="/">
                <img src="/images/logo.png" alt="Logo" class="h-8">
            </Link>
        </div>
        <div data-role="navigation-shortcuts" class="grid place-items-center grid-flow-col">
            <LanguageSwitch />
            <el-icon class="mx-3" size="20">
                <Bell />
            </el-icon>
            <el-dropdown class="mx-2">
                <span class="el-dropdown-link">
                    <el-icon size="20" class="el-icon--right">
                        <setting />
                    </el-icon>
                </span>
                <template #dropdown>
                    <el-dropdown-menu>
                        <el-dropdown-item><Link href="/profile">{{ $t('menu.profile')}}</Link></el-dropdown-item>
                        <el-dropdown-item><Link href="/preferences">{{ $t('menu.preferences')}}</Link></el-dropdown-item>
                        <el-dropdown-item divided><Link href="/logout" as="button" method="post" class="text-red-700">Logout</Link></el-dropdown-item>
                    </el-dropdown-menu>
                </template>
            </el-dropdown>
        </div>
    </nav>
</template>

<script>
import { defineComponent } from 'vue';
import { Bell, Setting } from '@element-plus/icons-vue';
import { Link } from "@inertiajs/vue3";
import LanguageSwitch from '@/Components/LanguageSwitch.vue';


export default defineComponent({
    components: { Bell, Link, Setting, LanguageSwitch },
    computed: {
        username() {

            /**
             * This data is set and send from app\Http\Middleware\HandleInertiaRequests.php, share().
             */
            return this.$page?.props?.auth?.user?.name;
        }
    },
});
</script>

<style scoped>

</style>
