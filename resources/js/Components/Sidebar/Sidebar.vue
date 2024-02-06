<template>
    <aside
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 pt-14 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidenav" id="drawer-navigation">
        <div class="h-full px-3 py-5 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2">
                <li v-for="item, index in menuItems">
                    <div v-if="item.submenu">
                        <button type="button"
                            class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            :aria-controls="'menu-submenu-trigger-' + (index + 1)" :data-collapse-toggle="'menu-submenu-trigger-' + (index + 1)">
                            <el-icon v-if="item.icon">
                                <component :is='item.icon' />
                            </el-icon>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ $t('menu.more') }}</span>
                            <el-icon class="submenu-icon"><ArrowDown /></el-icon>
                        </button>
                        <ul :id="'menu-submenu-trigger-' + (index + 1)" class="hidden py-2 space-y-2">
                            <li v-for="sub in item.submenu">
                                <a v-if="sub.link" :href="route(sub.link)"
                                    class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">{{ $t(sub.title) }}</a>
                                <a v-else href="#"
                                    class="flex items-center w-full p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">{{ $t(sub.title) }}</a>
                            </li>
                        </ul>
                    </div>
                    <div v-else>
                        <a v-if="item.route" :href="route(item.route)"
                        class="flex items-center p-2 text-base font-medium text-gray-900 transition-all duration-200 rounded-lg dark:text-white hover:bg-gray-200 dark:hover:bg-primary-700 dark:hover:text-white hover:text-gray-900 group"
                        :class="{'bg-primary-700 text-white hover:text-white hover:bg-primary-800': route().current() === item.route }">
                            <el-icon v-if="item.icon" :color="route().current() === item.route ? 'white' : 'rgb(107 114 128 / var(--tw-text-opacity))'">
                                <component :is="item.icon"/>
                            </el-icon>
                            <span class="ml-3">{{ $t(item.title) }}</span>
                        </a>
                        <a v-else href="#"
                        class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <el-icon v-if="item.icon" color="rgb(107 114 128 / var(--tw-text-opacity))">
                                <component :is="item.icon"/>
                            </el-icon>
                            <span class="ml-3">{{ $t(item.title) }}</span>
                        </a>
                    </div>
                </li>
            </ul>
            <!-- Secondary Menu -->
            <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
                <li>
                    <a :href="route('languages.index')"
                        class="flex items-center p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="24" width="24" class="object-fit" id="fi_2104994">
                            <g id="outline">
                                <path d="M370.931,102.051a8,8,0,0,0-2.895-5.788,174.894,174.894,0,0,0-94.463-39.394c-5.751-.572-11.6-.858-17.445-.863-.043,0-.085-.006-.128-.006s-.084.006-.127.006c-5.848,0-11.695.291-17.442.863a175.225,175.225,0,0,0-129.523,78.464l-.061.089h0a176.044,176.044,0,0,0,11.417,208.614,8,8,0,0,0,5.787,2.9c.127.006.253.008.38.008a8,8,0,0,0,5.656-2.342L368.6,108.087A8,8,0,0,0,370.931,102.051ZM230.056,224H180.944a235.387,235.387,0,0,1,9.92-60.224A507.977,507.977,0,0,0,248,167.928v38.128ZM96.222,224A159.08,159.08,0,0,1,119.1,149.149a505.249,505.249,0,0,0,55.761,12.307A251.43,251.43,0,0,0,164.938,224ZM243.007,72.531c1.659-.134,3.323-.251,4.993-.333v79.73a492.129,492.129,0,0,1-51.872-3.608A233.2,233.2,0,0,1,243.007,72.531ZM214.057,240l-30.149,30.148A237.173,237.173,0,0,1,180.95,240ZM264,167.929q11.5-.183,23.021-.893L264,190.056Zm40.476-18.349c-13.389,1.336-26.957,2.124-40.476,2.346V72.2c1.672.082,3.338.2,5,.333a234.1,234.1,0,0,1,43.993,68.532ZM218.7,76.37a248.394,248.394,0,0,0-38.813,69.673,489.955,489.955,0,0,1-51.261-10.866A159.106,159.106,0,0,1,218.7,76.37ZM127.167,326.89A160.316,160.316,0,0,1,96.209,240h68.729a252.685,252.685,0,0,0,5.261,43.858Zm197.995-198a249.34,249.34,0,0,0-31.87-52.527,158.8,158.8,0,0,1,57.6,26.8Z"></path>
                                <path d="M403.157,135.429a176.512,176.512,0,0,0-11.42-15.463,8,8,0,0,0-11.824-.563L143.4,355.913a8,8,0,0,0,.561,11.824,174.894,174.894,0,0,0,94.463,39.394A179.213,179.213,0,0,0,272,407.28V448a8,8,0,0,0,13.878,5.426L357.625,375.7a176.04,176.04,0,0,0,45.532-240.272ZM347.729,363.1a8.048,8.048,0,0,0-1.286,1.125L288,427.539v-29.25a8,8,0,0,0-9.132-7.92c-2.422.347-4.672.621-6.881.84a162.556,162.556,0,0,1-31.978,0,158.85,158.85,0,0,1-78.9-30.372L384.834,137.11q2.584,3.5,4.953,7.108A160.04,160.04,0,0,1,347.729,363.1Z"></path>
                                <circle cx="256" cy="312" r="16"></circle>
                                <circle cx="304" cy="312" r="16"></circle>
                                <circle cx="352" cy="312" r="16"></circle>
                                <path d="M79.992,340.062a8,8,0,0,0-8.93,6.946l-.676,5.4A208.021,208.021,0,0,1,93.63,84.217,8,8,0,1,0,82.37,72.85,224.007,224.007,0,0,0,56.932,361.087l-6.76-1a8,8,0,1,0-2.344,15.828l27,4a8,8,0,0,0,9.11-6.922l3-24A8,8,0,0,0,79.992,340.062Z"></path>
                                <path d="M454.534,96a8,8,0,0,0,0-16h-24a8,8,0,0,0-8,8v24a8,8,0,0,0,16,0v-2.638A208,208,0,0,1,418.316,378.37a8,8,0,0,0,11.368,11.26A224,224,0,0,0,448.521,96Z"></path>
                            </g>
                        </svg>
                        <span class="ml-3">{{ $t('menu.languages') }}</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        <svg aria-hidden="true"
                            class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-3">Dokumente</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        <svg aria-hidden="true"
                            class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z">
                            </path>
                        </svg>
                        <span class="ml-3">Archiv</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-base font-medium text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                        <svg aria-hidden="true"
                            class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-.08.08-1.53-1.533A5.98 5.98 0 004 10c0 .954.223 1.856.619 2.657l1.54-1.54zm1.088-6.45A5.974 5.974 0 0110 4c.954 0 1.856.223 2.657.619l-1.54 1.54a4.002 4.002 0 00-2.346.033L7.246 4.668zM12 10a2 2 0 11-4 0 2 2 0 014 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-3">Hilfe</span>
                    </a>
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
</template>

<script setup>
import { ArrowDown, Avatar, Folder, Histogram, List, More, TakeawayBox, User } from '@element-plus/icons-vue';
import { initFlowbite } from 'flowbite';
import { onMounted } from 'vue';
import menuItems from '@Config/mainMenu';

onMounted(() => {
    initFlowbite();
});

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