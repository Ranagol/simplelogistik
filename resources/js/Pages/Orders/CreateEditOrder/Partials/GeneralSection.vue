<template>
    <h2 @click="onToggleSection(props.section.key)" class="w-full mb-4 text-xl font-bold text-gray-900 cursor-pointer dark:text-white"><span>{{ props.title }}</span> <el-icon class="transition-all duration-200" :class="{'rotate-180' : props.sectionActive}"><ArrowDown /></el-icon></h2>
    <section class="py-3 mb-4" :class="{'border-b': props.sectionActive}">
        <div :class="{'hidden': !sectionActive}">
            <!-- Type of Transport -->
            <!-- TODO: (Andor) make types of transport to be fed from backend database -->
            
            <!-- TODO: (Patric) Implement Logic and Design for General Data editing in Frontend Controller -->
            
        </div>
    </section>
</template>
<script setup>
import { ArrowDown } from '@element-plus/icons-vue';
import { initFlowbite } from 'flowbite';
import { onMounted } from 'vue';

const props = defineProps({
    data: {
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
