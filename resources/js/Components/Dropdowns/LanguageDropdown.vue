<template>
    <button type="button" data-dropdown-toggle="language-dropdown"
        class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:hover:text-white dark:text-gray-400 hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
        <img :src="`/images/flags/${rct.locale ?? 'de'}.svg`" class="object-cover w-6 h-6 rounded-full">
    </button>
    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700"
        id="language-dropdown">
        <ul class="py-1" role="none">
            <li v-for="lang, index in getLanguages()" :key="index">
                <button
                    @click="changeLanguage($i18n, lang.code)"
                    class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100 dark:hover:text-white dark:text-gray-300 dark:hover:bg-gray-600"
                    role="menuitem">
                    <div class="inline-flex items-center">
                        <img :src="`/images/flags/${lang.code}.svg`" class="object-cover w-4 h-4 rounded-full">
                        <span class="pl-2">{{ $t(lang.label) }}</span>
                    </div>
                </button>
            </li>
        </ul>
    </div>
</template>
<script setup>

import {reactive} from "vue"

const rct = reactive({locale: sessionStorage.getItem('locale')})
const changeLanguage = (store, locale) => {
    store.locale = locale
    sessionStorage.setItem("locale", locale)
}
</script>
