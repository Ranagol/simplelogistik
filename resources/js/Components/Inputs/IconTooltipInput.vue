<template>
    <div :class="defaultWrapperClass">
        <input @keyup="keyup" :type="type" :value="value" :id="'floating-input-filed-' + _id" :placeholder="$t(placeholder ?? ' ') ?? ' '"
        :class="defaultInputClass"
        >
        <div :class="defaultIconWrapperClass">
            <el-icon v-if="tooltipText && tooltipText !== ''" :data-tooltip-target="'tooltip-icon-input-'+ _id" type="button" :color="iconColor ?? 'silver'" :size="iconSize ?? '18'"><QuestionFilled :class="iconClass" /></el-icon>
        </div>
        <label :class="defaultLabelClass" :for="'floating-input-filed-' + _id">{{$t(placeholder ?? '')}}</label>
        <div v-if="tooltipText && tooltipText !== ''" :id="'tooltip-icon-input-'+ _id" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
            {{ $t(tooltipText) }}
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>
</template>

<script setup>
    import { QuestionFilled } from '@element-plus/icons-vue';
    import { ref, onMounted } from 'vue';
    const $emit = defineEmits(['getValue'])
    const props = defineProps({
        type: String,
        value: String,
        id: String,
        keyup: Function,
        placeholder: String,
        tooltipText: String,
        iconSize: String,
        iconColor: String,
        iconClass: String,
    })

    onMounted(() => {
        initFlowbite()
    })

    const _id = ref(props.id ?? Math.random().toString(36).substring(7))

    const defaultWrapperClass = 'relative w-full';
    const defaultLabelClass = ''
        + 'absolute '
        + 'top-0 '
        + 'start-1 '
        + 'px-2 '
        + 'text-[15px] '
        // + 'font-bold '
        + '-translate-y-1/2 '
        + 'bg-white '
        + 'peer-focus:text-corporate-700 '
        // + 'peer-focus:font-bold '
        + 'peer-placeholder-shown:font-bold '
        + 'peer-placeholder-shown:top-1/2 '
        + 'peer-focus:top-0 '
        + 'transition-all '
        + 'duration-300 '
        + 'pointer-events-none '
    const defaultInputClass = ''
        + 'rounded-md w-full '
        + 'peer '
        + 'pr-8 '
        + 'text-[15px] '
        + 'text-black '
        + 'border-gray-300 '
        + 'focus:border-primary-700'
        + 'focus-outline:transparent '
    const defaultIconWrapperClass = ''
        + 'absolute '
        + 'top-0 '
        + 'end-2.5 '
        + 'top-1/2 '
        + '-translate-y-1/2 '
        

</script>