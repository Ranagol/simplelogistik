<template>
    <el-card>

        <div class="grid grid-cols-2 gap-2">

            <!-- 1 column: the svg logo -->
            <slot></slot>

            <!-- 2 column: the title, value, measure unit -->
            <div class="flex flex-col">
                <span>{{ props.title }}</span>
                
                <span>
                    {{ _.round(props.value, 2) }} {{ props.measureUnit }}
                </span>
            </div>
        </div>
        
        
    </el-card>
    
    
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import _ from 'lodash';


let props = defineProps({
    title: {
        type: String,
        required: true,
    },
    measureUnit: {
        type: String,
        required: true,
    },
    value: {
        type: Number,
        required: true,
    },
    
});


</script>

<style scoped>
</style>
