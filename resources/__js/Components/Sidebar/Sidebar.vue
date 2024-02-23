<template>
    <aside
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 pt-14 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidenav" id="drawer-navigation">
        <div class="h-full px-3 py-5 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2">
                <li class="cursor-pointer" v-for="item, index in menuItems">
                    <div v-if="item.submenu">
                        <button type="button"
                            class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            :aria-controls="'menu-submenu-trigger-' + (index + 1)" :data-collapse-toggle="'menu-submenu-trigger-' + (index + 1)">
                            <span v-if="item?.customIcon !== true">
                                <el-icon size="18" v-if="item.icon">
                                    <component :is='item.icon' />
                                </el-icon>
                                </span>
                            <span v-else>
                                <component :color="isActive(states.activeRoute, item.route) ? '#fff' : 'rgb(107 114 128 / var(--tw-text-opacity))'" size="18" :is="item.icon" />
                            </span>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ $t('menu.more') }}</span>
                            <el-icon size="18" class="submenu-icon"><ArrowDown /></el-icon>
                        </button>
                        <ul :id="'menu-submenu-trigger-' + (index + 1)" class="hidden py-2 space-y-2">
                            <li v-for="sub in item.submenu">
                                <p v-if="sub.link" @click="states.activeRoute = sub.link; router.visit(route(sub.link));"
                                    class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">{{ $t(sub.title) }}</p>
                                <p v-else
                                    class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">{{ $t(sub.title) }}</p>
                            </li>
                        </ul>
                    </div>
                    <div v-else>
                        <p v-if="item.route" @click="states.activeRoute = item.route; router.visit(route(item.route));"
                        class="grid justify-start grid-flow-col p-2 py-2.5 text-base font-medium text-gray-900 transition-all duration-200 rounded-lg place-items-center dark:text-white hover:bg-gray-200 dark:hover:bg-primary-700 dark:hover:text-white hover:text-gray-900 group"
                        :class="{'bg-primary-700 text-white hover:text-white hover:bg-primary-800': isActive(states.activeRoute, item.route) }">
                        <span v-if="item?.customIcon !== true" class="leading-none">
                            <el-icon size="18" v-if="item.icon" :color="isActive(states.activeRoute, item.route) ? '#fff' : 'rgb(107 114 128 / var(--tw-text-opacity))'">
                                <component :color="isActive(states.activeRoute, item.route) ? '#fff' : 'rgb(107 114 128 / var(--tw-text-opacity))'" :is="item.icon"/>
                            </el-icon>
                        </span>
                        <span v-else class="leading-none">
                            <component :color="isActive(states.activeRoute, item.route) ? '#fff' : 'rgb(107 114 128 / var(--tw-text-opacity))'" size="18" :is="item.icon" />
                        </span>
                        <span class="ml-3 leading-none">{{ $t(item.title) }}</span>
                        </p>
                        <p v-else
                        class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <el-icon size="18" v-if="item.icon" :color="isActive(states.activeRoute, item.route) ? '#fff' : 'rgb(107 114 128 / var(--tw-text-opacity))'">
                                <component :is="item.icon"/>
                            </el-icon>
                            <span class="ml-3">{{ $t(item.title) }}</span>
                        </p>
                    </div>
                </li>
            </ul>
            <!-- Secondary Menu -->
            <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
                
                <li v-for="item, index in sidebarSubmenuItems">
                    <div v-if="item.submenu">
                        <button type="button"
                            class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            :aria-controls="'menu-submenu-trigger-' + (index + 1)" :data-collapse-toggle="'menu-submenu-trigger-' + (index + 1)">
                            <span v-if="item?.customIcon !== true">
                                <el-icon size="18" v-if="item.icon">
                                    <component :is='item.icon' />
                                </el-icon>
                                </span>
                            <span v-else>
                                <component :is="item.icon" />
                            </span>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ $t('menu.more') }}</span>
                            <el-icon size="18" class="submenu-icon"><ArrowDown /></el-icon>
                        </button>
                        <ul :id="'menu-submenu-trigger-' + (index + 1)" class="hidden py-2 space-y-2">
                            <li v-for="sub in item.submenu">
                                <p v-if="sub.link" @click="states.activeRoute = sub.link; router.visit(route(sub.link));"
                                    class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">{{ $t(sub.title) }}</p>
                                <p v-else
                                    class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">{{ $t(sub.title) }}</p>
                            </li>
                        </ul>
                    </div>
                    <div v-else>
                        <p v-if="item.route" @click="states.activeRoute = item.route; router.visit(route(item.route));"
                        class="flex items-center p-2 text-base font-medium text-gray-900 transition-all duration-200 rounded-lg dark:text-white hover:bg-gray-200 dark:hover:bg-primary-700 dark:hover:text-white hover:text-gray-900 group"
                        :class="{'bg-primary-700 text-white hover:text-white hover:bg-primary-800': isActive(states.activeRoute, item.route) }">
                            <span v-if="item?.customIcon !== true">
                                <el-icon size="18" v-if="item.icon" :color="isActive(states.activeRoute, item.route) ? '#fff' : 'rgb(107 114 128 / var(--tw-text-opacity))'">
                                    <component :is="item.icon"/>
                                </el-icon>
                                </span>
                            <span v-else>
                                <component :is="item.icon" />
                            </span>
                            <span class="ml-3">{{ $t(item.title) }}</span>
                        </p>
                        <p v-else
                        class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <span v-if="item?.customIcon !== true">
                                <el-icon size="18" v-if="item.icon" color="rgb(107 114 128 / var(--tw-text-opacity))">
                                    <component :is="item.icon"/>
                                </el-icon>
                                </span>
                            <span v-else>
                                <component :is="item.icon" />
                            </span>
                            <span class="ml-3">{{ $t(item.title) }}</span>
                        </p>
                    </div>
                </li>
            </ul>
            <!-- Secondary Menu End -->
        </div>
        <div
            class="absolute bottom-0 left-0 z-20 justify-center hidden w-full p-4 space-x-4 bg-white lg:flex dark:bg-gray-800">
            <a href="#"
                class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-600">
                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z">
                    </path>
                </svg>
            </a>
            <a href="#" data-tooltip-target="tooltip-settings"
                class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:text-gray-400 dark:hover:text-white hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                        clip-rule="evenodd"></path>
                </svg>
            </a>
            <div id="tooltip-settings" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                Settings page
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
    </aside>

    
    {{ states.activeRoute === "" ? states.activeRoute = route().current() : null }}
</template>

<script setup>
import { ArrowDown, Avatar, Folder, Histogram, List, More, TakeawayBox, User } from '@element-plus/icons-vue';
import { initFlowbite } from 'flowbite';
import { onMounted } from 'vue';
import menuItems from '@Config/mainMenu';
import sidebarSubmenuItems from '@Config/sidebarMenuSecondary';
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';

const getBase = (route) => {
    return route.split('.')[0];
}

const isActive = (current, target) => {
    return (getBase(current) === getBase(target));
}


onMounted(() => {
    initFlowbite();
});

var states = reactive({
    activeRoute: ''
})

</script>
<style scoped>
    button[data-collapse-toggle="dropdown-authentication"][aria-expanded="true"] .submenu-icon{
        background: transparent !important;
        transform: rotate(-180deg);
        transition: transform 200ms ease
    }
    button[data-collapse-toggle="dropdown-authentication"][aria-expanded="false"] .submenu-icon{
        background: transparent !important;
        transform: rotate(0deg);
        transition: transform 200ms ease
    }
</style>