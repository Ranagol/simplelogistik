<script setup>
defineProps({
    actions: {
        type: Object,
        required: false
    },
    position: {
        type: String,
        required: true
    },
    spacer: {
        type: String,
        required: false
    }
});

</script>

<template>
    <div :class="spacer ?? 'py-0'">
        <div v-for="section in actions">
            <div v-if="section.position == position">
                <div class="grid w-full grid-flow-col my-2" :class="section.alignment ?? 'justify-end'" >
                    <button
                        v-for="button in section.buttons"
                        :key="button?.id ?? Math.random()"
                        class="inline-flex"
                        :class="getButtonStyle(button.action)"
                    >
                        <el-icon v-if="button.icon !== false" size="18"><component :is="button.icon"/></el-icon><span :class="{'ps-2': button.icon !== false}">{{ $t(button.label) }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>