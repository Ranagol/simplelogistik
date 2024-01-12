<template>
    <Link :href="link" @mouseover="showToolTip" @mouseout="hideToolTip" class="hoverable grid grid-flow-col place-items-center justify-start relative mb-4">
        <ToolTip :text="toolTipText" v-if="!menuOpen && toolTipText !== '' && toolTipState"/>
        <div class="icon" v-if="!hideIcon">
            <el-icon :size="iconSize">
                <slot name="icon"></slot>
            </el-icon>
        </div>
        <div class="content transition-all duration-[300ms] overflow-hidden" :class="{'w-0': !menuOpen, 'w-[250px]': menuOpen, flyout: flyout}">
            <span class="text-xl font-semibold pl-4"><slot name="title" /></span>
            <span><slot name="subtitle" /></span>
        </div>
    </Link>
</template>

<script setup>
import { Menu } from '@element-plus/icons-vue'
import ToolTip from './ToolTip.vue';
</script>
<script>
export default {
    name: 'SidebarMenuItem',
    data() 
    {
        return {
            toolTipState: false,
        }
    },
    methods: 
    {
        showToolTip() {
            this.toolTipState = true;
        },
        hideToolTip() {
            this.toolTipState = false;
        }
    },
    props: {
        hideIcon: {
            type: Boolean,
            default: false
        },
        toolTipVisible: {
            type: Boolean,
            default: false
        },
        iconSize: {
            type: String,
            default: "30"
        },
        link: {
            type: String,
            default: '#'
        },
        toolTipText: {
            type: String,
            default: ''
        },
        class: {
            type: String,
            default: ''
        },
        menuOpen: {
            type: Boolean,
            default: false
        },
        flyout: {
            type: Boolean,
            default: false
        }
    },
    components: {
        Menu, ToolTip
    }

}
</script>

<style scoped>
    .hoverable:hover > div * {
        color: rgb(96, 165, 250)
    }

    .flyout {
        min-width: 200px;
    }
</style>
