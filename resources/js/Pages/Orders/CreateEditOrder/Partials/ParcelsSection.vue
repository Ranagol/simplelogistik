<template>
    <h2 @click="onToggleSection(props.section.key)" class="w-full mb-4 text-lg font-bold text-gray-900 cursor-pointer dark:text-white"><span>{{ props.title }}</span> <el-icon class="transition-all duration-200" :class="{'rotate-180' : props.sectionActive}"><ArrowDown /></el-icon></h2>
    <section class="py-3 mb-4" :class="{'border-b': props.sectionActive}">
        <div :class="{'hidden': !sectionActive}">
            <div v-for="(parcel, index) in props.data" :key="index">
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative grid col-span-2 p-4 mb-2 rounded bg-gray-50">
                        <span class="font-bold text-corporate-700">{{ $t('labels.parcel') }} {{ index + 1 }}</span>
                        <div class="mt-3">
                            <p><span>{{ $t('labels.length') }}: {{ parcel.length }} cm</span></p>
                            <p><span>{{ $t('labels.width') }}: {{ parcel.width }} cm</span></p>
                            <p><span>{{ $t('labels.height') }}: {{ parcel.height }} cm</span></p>
                            <p><span>{{ $t('labels.weight') }}: {{ parcel.weight }} kg</span></p>
                        </div>
                    </div>
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
