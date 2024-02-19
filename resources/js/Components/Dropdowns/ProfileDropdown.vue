<template>
    <button type="button"
        class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-menu-dropdown">
        <span class="sr-only">Open user menu</span>
        <img class="w-8 h-8 rounded-full"
            src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png" alt="user photo" />
    </button>
    <!-- Dropdown menu -->
    <div class="z-50 hidden w-56 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 rounded-xl"
        id="user-menu-dropdown">
        <div class="px-4 py-3">
            <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ $page.props?.auth?.user?.name }}</span>
            <span class="block text-sm text-gray-900 truncate dark:text-white">{{ $page.props?.auth?.user?.email }}</span>
        </div>
        <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">
            <li>
                <Link @click="() => hideMenu" :href="route('profile.edit')"
                    class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">{{ $t('labels.my-profile') }}</Link>
            </li>
            <li>
                <Link @click="() => hideMenu" :href="route('profile.edit')"
                    class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">{{ $t('labels.account-settings') }}</Link>
            </li>
        </ul>
        <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">
            <li>
                <Link method="post" :href="route('logout')" as="button" type="button"
                    class="flex w-full px-4 py-2 text-sm text-red-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $t('labels.sign-out') }}</Link>
            </li>
        </ul>
    </div>
</template>

<script>
import { router, Link } from '@inertiajs/vue3';
import { initFlowbite } from 'flowbite';
import { onMounted } from 'vue';

const hideMenu = () => {
    var button = document.getElementById('user-menu-button')
    button.dispatchEvent(new Event('click'))
}

</script>
