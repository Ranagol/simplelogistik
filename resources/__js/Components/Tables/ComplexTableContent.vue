<script setup>
import TableCell from "@/Components/Tables/TableCell.vue"
import { ArrowDown, View } from "@element-plus/icons-vue";
const props = defineProps({
    content: {
        type: Object,
        required: true
    },
    cellConfig: {
        type: Object,
        required: true
    },
    row: {
        type: Number,
        required: true
    }
})

var colspan = 2
props.cellConfig.map((cell) => {
    cell.show ? colspan++ : null
})

</script>
<template>
    <tr class="transition border-b dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700" >
        <td class="w-4">
            <div class="grid p-3 bg-transparent cursor-pointer place-items-center"
            :id="'table-column-header-' + row" 
            :data-accordion-target="'#table-column-body-' + row" 
            aria-expanded="false" 
            :aria-controls="'table-column-body-' + row">
                <el-icon size="18"><ArrowDown /></el-icon>
            </div>
        </td>

        <td class="w-4 px-4 py-3">
            <div class="flex items-center ">
                <el-icon size="18"><View /></el-icon>
            </div>
        </td>
        
        <TableCell v-for="cell, ci in cellConfig" :cellConfig="cell" :content="content" :key="ci" class="p-3"/>
    </tr>
    <tr  class="flex-1 hidden w-full overflow-x-auto" 
        :id="'table-column-body-' + row" 
        :aria-labelledby="'table-column-header-' + row">
        <td class="p-4 border-b dark:border-gray-700" :colspan="colspan">
            <div class="grid grid-cols-4 gap-4 mb-4">
                <div class="relative flex items-center justify-center h-32 p-2 bg-gray-100 rounded-lg sm:w-full sm:h-36 dark:bg-gray-700">
                    <img src="https://flowbite.s3.amazonaws.com/blocks/application-ui/products/imac-front-image.png" alt="iMac Front Image" class="w-auto h-full">
                </div>
                <div class="relative flex items-center justify-center h-32 p-2 bg-gray-100 rounded-lg sm:w-full sm:h-36 dark:bg-gray-700">
                    <img src="https://flowbite.s3.amazonaws.com/blocks/application-ui/products/imac-side-image.png" alt="iMac Side Image" class="w-auto h-full">
                </div>
                <div class="relative flex items-center justify-center h-32 p-2 bg-gray-100 rounded-lg sm:w-full sm:h-36 dark:bg-gray-700">
                    <img src="https://flowbite.s3.amazonaws.com/blocks/application-ui/products/imac-back-image.png" alt="iMac Back Image" class="w-auto h-full">
                </div>
                <div class="relative flex items-center justify-center h-32 p-2 bg-gray-100 rounded-lg sm:w-full sm:h-36 dark:bg-gray-700">
                    <img src="https://flowbite.s3.amazonaws.com/blocks/application-ui/products/imac-back-image.png" alt="iMac Back Image" class="w-auto h-full">
                </div>
            </div>
            <div>
                <h6 class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">Details</h6>
                <div class="max-w-screen-md text-base text-gray-500 dark:text-gray-400">Standard glass, 3.8GHz 8-core 10th-generation Intel Core i7 processor, Turbo Boost up to 5.0GHz, 16GB 2666MHz DDR4 memory, Radeon Pro 5500 XT with 8GB of GDDR6 memory, 256GB SSD storage, Gigabit Ethernet, Magic Mouse 2, Magic Keyboard - US.</div>
            </div>
            <div class="grid grid-cols-4 gap-4 mt-4">
                <div class="relative flex flex-col items-start justify-between p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6 class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">Product State</h6>
                    <div class="bg-primary-100 text-primary-800 text-xs font-medium px-2.5 py-0.5 rounded-md dark:bg-primary-200 dark:text-primary-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        New
                    </div>
                </div>
                <div class="relative flex flex-col justify-between p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6 class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">Shipping</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        Worldwide
                    </div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6 class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">Colors</h6>
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 bg-purple-600 rounded-full"></div>
                        <div class="w-6 h-6 bg-indigo-400 rounded-full"></div>
                        <div class="w-6 h-6 rounded-full bg-primary-600"></div>
                        <div class="w-6 h-6 bg-pink-400 rounded-full"></div>
                        <div class="w-6 h-6 bg-teal-300 rounded-full"></div>
                        <div class="w-6 h-6 bg-green-300 rounded-full"></div>
                    </div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6 class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">Brand</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">Apple</div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6 class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">Sold by</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">Flowbite</div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6 class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">Ships from</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">Flowbite</div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6 class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">Dimensions (cm)</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">105 x 15 x 23</div>
                </div>
                <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <h6 class="mb-2 text-base font-medium leading-none text-gray-900 dark:text-white">Item weight</h6>
                    <div class="flex items-center text-gray-500 dark:text-gray-400">12kg</div>
                </div>
            </div>
            <div class="flex items-center mt-4 space-x-3">
                <button type="button" class="flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                    </svg>
                    Edit
                </button>
                <button type="button" class="flex items-center px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Preview</button>
                <button type="button" class="flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Delete
                </button>
            </div>
        </td>
    </tr>
</template>

<style scoped>
    [aria-expanded="false"] {
        transform: rotate(0deg);
        transition: transform 0.3s;
    }
    [aria-expanded="true"] {
        transform: rotate(180deg);
        transition: transform 0.3s;
    }
</style>