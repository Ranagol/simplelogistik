<template>
    <h2 @click="onToggleSection(props.section.key)" class="w-full mb-4 text-xl font-bold text-gray-900 cursor-pointer dark:text-white"><span>{{ props.title }}</span> <el-icon class="transition-all duration-200" :class="{'rotate-180' : props.sectionActive}"><ArrowDown /></el-icon></h2>
    <section class="py-3 mb-4" :class="{'border-b': props.sectionActive}">
        <div class="grid grid-cols-4 gap-4" :class="{'hidden': !sectionActive}">
            <div class="relative p-4 pt-8 bg-gray-200 rounded" v-for="address in (tabData.sort((a,b) => a.order > b.order))">
                <span v-if="address.address_type === 'labels.address-delivery'" class="absolute block px-2 text-[12px] text-white rounded-sm top-2 right-2 bg-primary-600">
                    {{ address.address_type }}
                </span>
                <span v-else="address.address_type === 'labels.address-delivery'" class="absolute block px-2 text-[12px] text-orange-900 bg-orange-300 rounded-sm top-2 right-2">
                    {{ address.address_type }}
                </span>
                <div class="text-1">
                    <p v-if="address.company_name"><span :class="{'font-bold': address.company_name}">{{ address.company_name }}</span></p>
                    <p><span>{{ address.first_name }} {{ address.last_name }}</span></p>
                    <p><span>{{ address.street }} {{ address.house_number }}</span></p>
                    <p><span>{{ address.zip_code }} {{ address.city }}</span></p>
                    <p><span>{{ address.state }} {{ address.country.country_name }}</span></p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ArrowDown } from '@element-plus/icons-vue';
import { initFlowbite } from 'flowbite';
import { onMounted } from 'vue';

const props = defineProps({
    tabData: {
        type: Array,
        required: true
    },
    onToggleSection: {
        type: Function,
        required: true
    },
    section: {
        type: Object,
        required: true
    },
    sectionActive: {
        type: Boolean,
        required: true
    },
    title: {
        type: String,
        required: true
    }
})

const onToggleSection = (section) => {
    props.onToggleSection(section);
}

onMounted(() => {
    initFlowbite();
})

</script>
