<template>
    <h2 @click="onToggleSection(props.section.key)" class="w-full mb-4 text-lg font-bold text-gray-900 cursor-pointer dark:text-white"><span>{{ props.title }}</span> <el-icon class="transition-all duration-200" :class="{'rotate-180' : props.sectionActive}"><ArrowDown /></el-icon></h2>
    <section class="py-3 mb-4" :class="{'border-b': props.sectionActive}">
        <div :class="{'hidden': !sectionActive}">
            <div class="grid justify-between grid-flow-col">
                <div class="">Transportkosten</div>
                <div class="">Transportkosten</div>
            </div>
            <div class="grid justify-between grid-flow-col">
                <div class="">Transportkosten</div>
                <div class="">Transportkosten</div>
            </div>
            <div class="grid justify-between grid-flow-col">
                <div class="">Transportkosten</div>
                <div class="">Transportkosten</div>
            </div>
        </div>
    </section>
</template>
<script setup>
import { ArrowDown } from '@element-plus/icons-vue';
import { initFlowbite } from 'flowbite';
import { onMounted, reactive } from 'vue';

const positions = reactive([]);
const options = reactive([]);
const discounts = reactive([]);

const props = defineProps({
    data: {
        type: Object,
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
