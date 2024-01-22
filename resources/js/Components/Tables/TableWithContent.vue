<template>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="mx-auto max-w-screen-2xl">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <div class="w-full flex items-center space-x-3">
                        <h5 class="dark:text-white font-semibold">Flowbite Products</h5>
                        <div class="text-gray-400 font-medium">6,560 results</div>
                        <div data-tooltip-target="results-tooltip">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewbox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="sr-only">More info</span>
                        </div>
                        <div id="results-tooltip" role="tooltip"
                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Showing 1-10 of 6,560 results
                            <div class="tooltip-arrow" data-popper-arrow=""></div>
                        </div>
                    </div>
                    <div class="w-full flex flex-row items-center justify-end space-x-3">
                        <button type="button"
                            class="w-full md:w-auto flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add new product
                        </button>
                        <button type="button"
                            class="w-full md:w-auto flex items-center justify-center py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            <svg class="mr-2 w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                stroke="currentColor" viewbox="0 0 12 13" aria-hidden="true">
                                <path d="M1 2V1h10v3H1V2Zm0 4h5v6H1V6Zm8 0h2v6H9V6Z" />
                            </svg>
                            Manage Columns
                        </button>
                    </div>
                </div>
                <div
                    class="flex flex-col-reverse md:flex-row items-start md:items-center justify-between md:space-x-4 p-4 border-b dark:border-gray-700">
                    <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                        class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400"
                            viewbox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                clip-rule="evenodd" />
                        </svg>
                        Filter
                        <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                    <div id="filterDropdown" class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                        <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose brand</h6>
                        <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                            <li class="flex items-center">
                                <input id="apple" type="checkbox" value=""
                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="apple" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Apple
                                    (56)</label>
                            </li>
                            <li class="flex items-center">
                                <input id="fitbit" type="checkbox" value=""
                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="fitbit"
                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Microsoft (16)</label>
                            </li>
                            <li class="flex items-center">
                                <input id="razor" type="checkbox" value=""
                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="razor" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Razor
                                    (49)</label>
                            </li>
                            <li class="flex items-center">
                                <input id="nikon" type="checkbox" value=""
                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="nikon" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nikon
                                    (12)</label>
                            </li>
                            <li class="flex items-center">
                                <input id="benq" type="checkbox" value=""
                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="benq" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">BenQ
                                    (74)</label>
                            </li>
                        </ul>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 w-full lg:w-2/3 md:gap-4">
                        <div class="w-full"><label for="brand" class="sr-only">Brand</label><select id="brand"
                                class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                <option selected="">Brand</option>
                                <option value="purple">Samsung</option>
                                <option value="primary">Apple</option>
                                <option value="pink">Pink</option>
                                <option value="green">Green</option>
                            </select></div>
                        <div class="w-full"><label for="price" class="sr-only">Price</label><select id="price"
                                class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                <option selected="">Price</option>
                                <option value="below-100">$ 1-100</option>
                                <option value="below-500">$ 101-500</option>
                                <option value="below-1000">$ 501-1000</option>
                                <option value="over-1000">$ 1001+</option>
                            </select></div>
                        <div class="w-full"><label for="category" class="sr-only">Category</label><select id="category"
                                class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                <option selected="">Category</option>
                                <option value="pc">PC</option>
                                <option value="phone">Phone</option>
                                <option value="tablet">Tablet</option>
                                <option value="console">Gaming/Console</option>
                            </select></div>
                        <div class="w-full"><label for="color" class="sr-only">Color</label><select id="color"
                                class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                <option selected="">Color</option>
                                <option value="purple">Purple</option>
                                <option value="primary">primary</option>
                                <option value="pink">Pink</option>
                                <option value="green">Green</option>
                            </select></div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all" type="checkbox"
                                            class="w-4 h-4 text-primary-600 bg-gray-100 rounded border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Expand/Collapse Row</span>
                                </th>
                                <th scope="col" class="px-4 py-3 min-w-[14rem]">Product</th>
                                <th scope="col" class="px-4 py-3 min-w-[10rem]">
                                    Category
                                    <svg class="h-4 w-4 ml-1 inline-block" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" />
                                    </svg>
                                </th>
                                <th scope="col" class="px-4 py-3 min-w-[6rem]">
                                    Brand
                                    <svg class="h-4 w-4 ml-1 inline-block" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" />
                                    </svg>
                                </th>
                                <th scope="col" class="px-4 py-3 min-w-[6rem]">
                                    Price
                                    <svg class="h-4 w-4 ml-1 inline-block" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" />
                                    </svg>
                                </th>
                                <th scope="col" class="px-4 py-3 min-w-[6rem]">
                                    Stock
                                    <svg class="h-4 w-4 ml-1 inline-block" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" />
                                    </svg>
                                </th>
                                <th scope="col" class="px-4 py-3 min-w-[12rem]">
                                    Total Sales
                                    <svg class="h-4 w-4 ml-1 inline-block" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" />
                                    </svg>
                                </th>
                                <th scope="col" class="px-4 py-3 min-w-[7rem]">
                                    Status
                                    <svg class="h-4 w-4 ml-1 inline-block" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" />
                                    </svg>
                                </th>
                            </tr>
                        </thead>
                        <tbody data-accordion="table-column">
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer transition"
                                id="table-column-header-0" data-accordion-target="#table-column-body-0"
                                aria-expanded="false" aria-controls="table-column-body-0">
                                <td class="px-4 py-3 w-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-1" type="checkbox"
                                            onclick="event.stopPropagation()"
                                            class="w-4 h-4 text-primary-600 bg-gray-100 rounded border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <td class="p-3 w-4">
                                    <svg data-accordion-icon="" class="w-6 h-6 shrink-0" fill="currentColor"
                                        viewbox="0 0 20 20" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </td>
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center">
                                    <img src="https://flowbite.s3.amazonaws.com/blocks/application-ui/products/imac-front-image.png"
                                        alt="iMac Front Image" class="h-8 w-auto mr-3">
                                    Apple iMac 27&#34;
                                </th>
                                <td class="px-4 py-3">PC</td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">Apple</td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">$2999</td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">200</td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">245</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div
                                        class="w-fit bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-100 dark:text-green-800">
                                        Active</div>
                                </td>

                            </tr>
                            <tr class="hidden flex-1 overflow-x-auto w-full" id="table-column-body-0"
                                aria-labelledby="table-column-header-0">
                                <td class="p-4 border-b dark:border-gray-700" colspan="9">
                                    <div class="grid grid-cols-4 gap-4 mb-4">
                                        <div
                                            class="relative p-2 bg-gray-100 rounded-lg sm:w-full h-32 sm:h-36 dark:bg-gray-700 flex items-center justify-center">
                                            <img src="https://flowbite.s3.amazonaws.com/blocks/application-ui/products/imac-front-image.png"
                                                alt="iMac Front Image" class="h-full w-auto">
                                        </div>
                                        <div
                                            class="relative p-2 bg-gray-100 rounded-lg sm:w-full h-32 sm:h-36 dark:bg-gray-700 flex items-center justify-center">
                                            <img src="https://flowbite.s3.amazonaws.com/blocks/application-ui/products/imac-side-image.png"
                                                alt="iMac Side Image" class="h-full w-auto">
                                        </div>
                                        <div
                                            class="relative p-2 bg-gray-100 rounded-lg sm:w-full h-32 sm:h-36 dark:bg-gray-700 flex items-center justify-center">
                                            <img src="https://flowbite.s3.amazonaws.com/blocks/application-ui/products/imac-back-image.png"
                                                alt="iMac Back Image" class="h-full w-auto">
                                        </div>
                                        <div
                                            class="relative p-2 bg-gray-100 rounded-lg sm:w-full h-32 sm:h-36 dark:bg-gray-700 flex items-center justify-center">
                                            <img src="https://flowbite.s3.amazonaws.com/blocks/application-ui/products/imac-back-image.png"
                                                alt="iMac Back Image" class="h-full w-auto">
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-2 text-base leading-none font-medium text-gray-900 dark:text-white">
                                            Details</h6>
                                        <div class="text-base text-gray-500 dark:text-gray-400 max-w-screen-md">Standard
                                            glass, 3.8GHz 8-core 10th-generation Intel Core i7 processor, Turbo Boost up to
                                            5.0GHz, 16GB 2666MHz DDR4 memory, Radeon Pro 5500 XT with 8GB of GDDR6 memory,
                                            256GB SSD storage, Gigabit Ethernet, Magic Mouse 2, Magic Keyboard - US.</div>
                                    </div>
                                    <div class="grid grid-cols-4 gap-4 mt-4">
                                        <div
                                            class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700 flex flex-col items-start justify-between">
                                            <h6
                                                class="mb-2 text-base leading-none font-medium text-gray-900 dark:text-white">
                                                Product State</h6>
                                            <div
                                                class="bg-primary-100 text-primary-800 text-xs font-medium px-2.5 py-0.5 rounded-md dark:bg-primary-200 dark:text-primary-800 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1"
                                                    viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                New
                                            </div>
                                        </div>
                                        <div
                                            class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700 flex flex-col justify-between">
                                            <h6
                                                class="mb-2 text-base leading-none font-medium text-gray-900 dark:text-white">
                                                Shipping</h6>
                                            <div class="flex items-center text-gray-500 dark:text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1"
                                                    viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Worldwide
                                            </div>
                                        </div>
                                        <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                                            <h6
                                                class="mb-2 text-base leading-none font-medium text-gray-900 dark:text-white">
                                                Colors</h6>
                                            <div class="flex items-center space-x-2">
                                                <div class="rounded-full h-6 w-6 bg-purple-600"></div>
                                                <div class="rounded-full h-6 w-6 bg-indigo-400"></div>
                                                <div class="rounded-full h-6 w-6 bg-primary-600"></div>
                                                <div class="rounded-full h-6 w-6 bg-pink-400"></div>
                                                <div class="rounded-full h-6 w-6 bg-teal-300"></div>
                                                <div class="rounded-full h-6 w-6 bg-green-300"></div>
                                            </div>
                                        </div>
                                        <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                                            <h6
                                                class="mb-2 text-base leading-none font-medium text-gray-900 dark:text-white">
                                                Brand</h6>
                                            <div class="flex items-center text-gray-500 dark:text-gray-400">Apple</div>
                                        </div>
                                        <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                                            <h6
                                                class="mb-2 text-base leading-none font-medium text-gray-900 dark:text-white">
                                                Sold by</h6>
                                            <div class="flex items-center text-gray-500 dark:text-gray-400">Flowbite</div>
                                        </div>
                                        <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                                            <h6
                                                class="mb-2 text-base leading-none font-medium text-gray-900 dark:text-white">
                                                Ships from</h6>
                                            <div class="flex items-center text-gray-500 dark:text-gray-400">Flowbite</div>
                                        </div>
                                        <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                                            <h6
                                                class="mb-2 text-base leading-none font-medium text-gray-900 dark:text-white">
                                                Dimensions (cm)</h6>
                                            <div class="flex items-center text-gray-500 dark:text-gray-400">105 x 15 x 23
                                            </div>
                                        </div>
                                        <div class="relative p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                                            <h6
                                                class="mb-2 text-base leading-none font-medium text-gray-900 dark:text-white">
                                                Item weight</h6>
                                            <div class="flex items-center text-gray-500 dark:text-gray-400">12kg</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3 mt-4">
                                        <button type="button"
                                            class="py-2 px-3 flex items-center text-sm font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewbox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Edit
                                        </button>
                                        <button type="button"
                                            class="py-2 px-3 flex items-center text-sm font-medium text-center text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Preview</button>
                                        <button type="button"
                                            class="py-2 px-3 flex items-center text-sm font-medium text-center text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewbox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col items-start justify-between p-4 space-y-3 md:flex-row md:items-center md:space-y-0"
                    aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Showing
                        <span class="font-semibold text-gray-900 dark:text-white">1-10</span>
                        of
                        <span class="font-semibold text-gray-900 dark:text-white">1000</span>
                    </span>
                    <ul class="inline-flex items-stretch -space-x-px">
                        <li>
                            <a href="#"
                                class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page"
                                class="z-10 flex items-center justify-center px-3 py-2 text-sm leading-tight border text-primary-600 bg-primary-50 border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</template>

<script setup>
import { initFlowbite } from 'flowbite';
import { onMounted } from 'vue';

onMounted(() => {
    initFlowbite();
})
const dummyEntries = [
    {
        id: 1,
        name: 'John Doe',
        address: '123 Main St.',
        postal_code: '12345',
        city: 'New York',
        country: 'USA',
        paymentMethod: 'Credit Card',
        amount: 100.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-01-01',
        time: '12:00:00'
    },
    {
        id: 2,
        name: 'Jane Smith',
        address: '456 Elm St.',
        postal_code: '67890',
        city: 'Los Angeles',
        country: 'USA',
        paymentMethod: 'PayPal',
        amount: 50.00,
        status: 'Pending',
        statusCode: 2,
        date: '2021-02-01',
        time: '14:30:00'
    },
    // Add more entries here...
    {
        id: 3,
        name: 'Alice Johnson',
        address: '789 Oak St.',
        postal_code: '54321',
        city: 'Chicago',
        country: 'USA',
        paymentMethod: 'Bank Transfer',
        amount: 75.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-05-01',
        time: '09:45:00'
    },
    {
        id: 4,
        name: 'Bob Williams',
        address: '321 Pine St.',
        postal_code: '98765',
        city: 'San Francisco',
        country: 'USA',
        paymentMethod: 'Cash',
        amount: 200.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-06-01',
        time: '16:00:00'
    },
    {
        id: 5,
        name: 'Michael Johnson',
        address: '789 Oak St.',
        postal_code: '54321',
        city: 'Chicago',
        country: 'USA',
        paymentMethod: 'Bank Transfer',
        amount: 75.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-05-01',
        time: '09:45:00'
    },
    {
        id: 6,
        name: 'John Doe',
        address: '123 Main St.',
        postal_code: '12345',
        city: 'New York',
        country: 'USA',
        paymentMethod: 'Credit Card',
        amount: 100.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-01-01',
        time: '12:00:00'
    },
    {
        id: 7,
        name: 'Jane Smith',
        address: '456 Elm St.',
        postal_code: '67890',
        city: 'Los Angeles',
        country: 'USA',
        paymentMethod: 'PayPal',
        amount: 50.00,
        status: 'Pending',
        statusCode: 2,
        date: '2021-02-01',
        time: '14:30:00'
    },
    {
        id: 8,
        name: 'Alice Johnson',
        address: '789 Oak St.',
        postal_code: '54321',
        city: 'Chicago',
        country: 'USA',
        paymentMethod: 'Bank Transfer',
        amount: 75.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-05-01',
        time: '09:45:00'
    },
    {
        id: 9,
        name: 'Bob Williams',
        address: '321 Pine St.',
        postal_code: '98765',
        city: 'San Francisco',
        country: 'USA',
        paymentMethod: 'Cash',
        amount: 200.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-06-01',
        time: '16:00:00'
    },
    {
        id: 20,
        name: 'Michael Johnson',
        address: '789 Oak St.',
        postal_code: '54321',
        city: 'Chicago',
        country: 'USA',
        paymentMethod: 'Bank Transfer',
        amount: 75.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-05-01',
        time: '09:45:00'
    }
];
</script>
