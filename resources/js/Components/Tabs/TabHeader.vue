<template>
        <li class="me-2" role="presentation">
            <div 
            :id="'tab-' + target" 
            :data-tabs-target="'#'+target" 
            type="button" 
            role="tab" 
            :aria-controls="target" 
            aria-selected="false"
            class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg cursor-pointer hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
            <el-icon class="pr-2" v-if="icon" size="26">
                <component :is="icon" />
            </el-icon>
            {{ $t(title) ?? "TAB"}}
            </div>
        </li>
</template>

<script>
export default {
    props: {
        target: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        icon: {
            type: Object,
            required: false
        },
        active: {
            type: Boolean,
            required: false
        },
    }
}
</script>