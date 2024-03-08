<script setup>
    import SearchHelper from '@/lib/SearchHelper';
    import { Search } from '@element-plus/icons-vue';
    import { ref } from 'vue';
    const props = defineProps({
        searchConfig: {
            type: Object,
            required: true
        }
    })

    var searchSections = ref(props.searchConfig);
    var selectedSearchFields = ref([]);
    var searchString = "";
    const search = () => {
        
    }

    const setSearchField = (field, relation = false) => {
        let searchField = "";
        if (relation !== false) {
            searchField = relation + "__" + field;
        } else {
            searchField = field;
        }

        selectedSearchFields.value.push(searchField);
    }

    const isActive = (field, relation = false, activeFields) => {
        let searchField = "";
        if (relation !== false) {
            searchField = relation + "__" + field;
        } else {
            searchField = field;
        }

        return activeFields.contains(searchField);
    }
</script>

<template>
    <div class="border rounded-md overflow-clip">
        <div class="inline-flex divide-x">
            <input v-model="searchString" type="search" class="w-full p-2 px-4 text-sm text-gray-700 border-none rounded-md outline-0 ring-0 focus:outline-0 focus:ring-0 focus:border-primary-700 dark:text-gray-200" :placeholder="$t('labels.general.search')" />
            <button id="search-filter-dropdown-button" data-dropdown-toggle="search-filter-dropdown" class="p-2 px-4 bg-slate-50" type="button">
                <el-icon><Search /></el-icon>
            </button>
            <button @click.prevent="search" class="px-3 text-sm text-white bg-primary-700 dark:bg-primary-600">{{ $t('buttons.general.search') }}</button>
        </div>
    </div>
    <div id="search-filter-dropdown" class="z-50 hidden bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600">
        <div class="overflow-y-scroll max-h-48">
            <ul v-for="section,si in searchSections" class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="search-filter-dropdown-button">
                <li class="uppercase border-t first:border-t-0 text-[14px] p-2 mb-2 px-4 whitespace-nowrap">{{ $t(section.sectionTitle ?? section.section ?? '') }}</li>
                <li v-for="field,fi in section.fields" @click="setSearchField(field.name, section.relation)" :key="si + '.' + fi" class="grid px-4 pb-2">
                    <label class="grid justify-start grid-flow-col gap-2">
                        <input type="checkbox" /><span>{{ field.label }}</span>
                    </label>
                </li>
            </ul>
        </div>
        <div class="py-1">
            <a @click.prevent="reset" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">{{ $t('buttons.general.reset_filters') }}</a>
        </div>
    </div>
</template>