<script setup>

import { initFlowbite } from 'flowbite';
import { ref, onMounted } from 'vue';

onMounted(() => {
    initFlowbite()
})

const props = defineProps({
    config: {
        type: Object,
        required: true
    }
})

var searchInput = ref('');
var activeSelection = ref('');
var options = ref([]);

function getActiveLabel(key) {
    return options.value.find((a) => a.key === key).name;
}

function updateValue(value) {
    activeSelection.value = value;
}

</script>

<template>
    <div class="relative grid w-full">
        <button :id="'customDropDownButton' + _id ?? 'item'" :data-dropdown-toggle="'custom-dropdown-' + _id ?? 'item'" 
        class="inline-flex items-center p-3 py-2 text-center bg-white border rounded-md border-primary-700" type="button">
            <span class="grid justify-between w-full grid-flow-col mr-2 place-items-center">{{ $t(getActiveLabel(activeSelection)) }} <el-icon><ArrowDown class="w-4 h-4" /></el-icon></span>
        </button>

        <!-- Dropdown menu -->
        <div  :id="'custom-dropdown-' + _id ?? 'item'" class="z-10 hidden w-full overflow-y-scroll bg-white divide-y divide-gray-100 rounded-lg shadow max-h-96 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" :aria-labelledby="'customDropDownButton' + _id ?? 'item'">
                <li v-if="searchable" class="p-2">
                    <input type="text" class="flex w-full px-4 py-2 rounded" :value="searchInput" @input="e => {searchInput = e.target.value; options.filter((a) => {a.hidden = !a.name.includes(e.target.value); console.log(a)})}" placeholder="Search..." />
                </li>
                <li class="cursor-pointer" :class="{hidden: option.hidden === true}" v-for="option, index in options" :key="index" @click.prevent="() => {updateValue(option.key);} ">
                    <span :class="{'bg-primary-700 text-white hover:bg-primary-800' : option.key === activeSelection }" class="block px-4 py-2 hover:bg-gray-100">{{ $t(option.name) }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>