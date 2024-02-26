<template>
    <Head title="Dienstleister bearbeiten" />
    <div class="grid justify-start place-items-center">
        <a @click="router.visit(route('forwarders.index'))"><el-icon><ArrowLeft></ArrowLeft></el-icon><span class="p-2">Zurück</span></a>
    </div>
    <Card class="shadow">
        <div class="grid grid-cols-2 gap-4">
            <div v-for="(value, key) in record" :key="key">
                <IconTooltipInput 
                    :placeholder="'labels.' + key" 
                    :value="value" 
                    :id="key" 
                    :keyup="($event) => { record[key] = $event.target.value }" 
                />
            </div>
        </div>
    </Card>
    
    
    {{ record }}
</template>

<script setup>
import IconTooltipInput from '@/Components/Inputs/IconTooltipInput.vue';
import Card from '@/Shared/Card.vue';
import { ArrowLeft } from '@element-plus/icons-vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    record: {
        type: Object,
        required: true
    }
})
</script>