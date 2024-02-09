<template>
    <div class="relative grid w-full">
        <button :id="'customDropDownButton' + _id ?? 'item'" :data-dropdown-toggle="'custom-dropdown-' + _id ?? 'item'" 
        class="inline-flex items-center p-3 py-2 text-center bg-white border rounded-md border-primary-700" type="button">
            <span class="grid justify-between w-full grid-flow-col mr-2 place-items-center">{{ $t(getActiveLabel(activeSelection)) }} <el-icon><ArrowDown class="w-4 h-4" /></el-icon></span>
        </button>
        <label class="absolute px-1 font-bold -translate-y-1/2 bg-white start-2 text-corporate-700" v-if="floating" :for="'customDropDownButton' + _id ?? 'item'">{{ $t(labelText) }}</label>

        <!-- Dropdown menu -->
        <div :id="'custom-dropdown-' + _id ?? 'item'" class="z-10 hidden w-full bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" :aria-labelledby="'customDropDownButton' + _id ?? 'item'">
                <li class="cursor-pointer" v-for="option, index in options" @click.prevent="updateValue(option.key)">
                    <span :class="{'bg-primary-700 text-white hover:bg-primary-800' : option.key === activeSelection }" class="block px-4 py-2 hover:bg-gray-100">{{ $t(option.name) }}</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
    import { ArrowDown } from '@element-plus/icons-vue';
    import { ref } from 'vue';
    
    const props = defineProps({
        id: {
            type: String,
            required: false
        },
        options: {
            type: Array,
            required: true
        },
        floating: {
            type: Boolean,
            required: false,
        },
        labelText: {
            type: String,
            required: false,
            default: 'TEST'
        },
        updateValue: {
            type: Function,
            required: true
        },
        value: {
            type: String,
            required: true
        }
    })

    var activeSelection = ref(props.value ?? props.options[0].key);
    
    const updateValue = (key) => {
        activeSelection = ref(key);
        props.updateValue(key);
    }

    var _id = ref(props.id ?? Math.random().toString(36).substring(7));
    
    const getActiveLabel = (key) => {
        return props.options.find(option => option.key === key).name;
    }
    
</script>