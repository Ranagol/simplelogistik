<template>
    <div class="w-full p-4 border border-gray-200 bg-gray-50 rounded-t-xl">
        <div class="grid grid-cols-3">
            <h3 class="col-span-2 font-semibold text-gray-900 text-md dark:text-white">Order History</h3>
        </div>
    </div>
    <div class="px-3 py-4 border border-gray-200rounded-b-xl">
        <ol class="relative mx-3 border-gray-200 border-s dark:border-gray-700">
            <li class="mb-10 ms-6">
                <span
                    class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                    <img class="rounded-full shadow-lg" src="https://i.pravatar.cc/80?image=1" alt="Bonnie image" />
                </span>
                <div
                    class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
                    <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">just now</time>
                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300">Bonnie moved <a href="#"
                            class="font-semibold text-blue-600 dark:text-blue-500 hover:underline">Jese Leos</a> to <span
                            class="bg-gray-100 text-gray-800 text-xs font-normal me-2 px-2.5 py-0.5 rounded dark:bg-gray-600 dark:text-gray-300">Funny
                            Group</span></div>
                </div>
            </li>
            <li class="mb-10 ms-6">
                <span
                    class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                    <img class="rounded-full shadow-lg" src="https://i.pravatar.cc/80?image=2" alt="Thomas Lean image" />
                </span>
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                    <div class="items-center justify-between mb-3 sm:flex">
                        <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">2 hours ago</time>
                        <div class="text-sm font-normal text-gray-500 lex dark:text-gray-300">Thomas Lean commented on <a
                                href="#" class="font-semibold text-gray-900 dark:text-white hover:underline">Flowbite
                                Pro</a></div>
                    </div>
                    <div
                        class="p-3 text-xs italic font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">
                        Hi ya'll! I wanted to share a webinar zeroheight is having regarding how to best measure your design
                        system! This is the second session of our new webinar series on #DesignSystems discussions where
                        we'll be speaking about Measurement.</div>
                </div>
            </li>
            <li class="ms-6">
                <span
                    class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                    <img class="rounded-full shadow-lg" src="https://i.pravatar.cc/80?image=3" alt="Jese Leos image" />
                </span>
                <div
                    class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
                    <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">1 day ago</time>
                    <div class="text-sm font-normal text-gray-500 lex dark:text-gray-300">Jese Leos has changed <a href="#"
                            class="font-semibold text-blue-600 dark:text-blue-500 hover:underline">Pricing page</a> task
                        status to <span class="font-semibold text-gray-900 dark:text-white">Finished</span></div>
                </div>
            </li>
        </ol>
    </div>
</template>


<script setup>
const props = defineProps({
    tabData: {
        type: Object,
        required: false
    }
})
</script>