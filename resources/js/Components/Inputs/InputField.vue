<script setup>
    import { QuestionFilled } from '@element-plus/icons-vue';
    import { onMounted } from 'vue';
    const props = defineProps({
        store: Object,
        field: Object,
        data: Object,
    })

    const onInput = (name, value) => {
        props.store.update(name,value)
    }

    // var value = ref(props.store?.record[props.field.name])
    
    var value = props.field.subfield ?  props.data[props.field.name][props.field.subfield ] : props.data[props.field.name]
    onMounted(() => {
        initFlowbite()
    })

    const defaultWrapperClass = 'relative ' + ' w-full ';
    const defaultLabelClass = '' + 'absolute ' + 'top-0 ' + 'start-1 ' + 'px-2 ' + 'text-[15px] ' + '-translate-y-1/2 ' + 'bg-white ' + 'peer-focus:text-corporate-700 ' + 'peer-placeholder-shown:top-1/2 ' + 'peer-focus:top-0 ' + 'transition-all ' + 'duration-300 ' + 'pointer-events-none ';
    const defaultInputClass = '' + 'rounded-md '  + 'w-full ' + 'peer ' + 'pr-8 ' + 'text-[15px] ' + 'text-black ' + 'border-gray-300 ' + 'focus:border-primary-700 ' + 'ring-0 ' + 'focus:ring-0 ';
    const defaultIconWrapperClass = '' + 'absolute ' + 'top-0 ' + 'end-2.5 ' + 'top-1/2 ' + '-translate-y-1/2 ';
    
    const _id = Math.random().toString(36).substring(7);
</script>

<template>
    <div class="col-span-12" :class="field.size ?? 'col-span-12'">
        <div :class="defaultWrapperClass">
            <input :required="field.required ?? false" @input="(e) => onInput(field.name, e.target.value)" :type="field?.type ?? 'text'" :value="value" :id="'floating-input-filed-' + _id" :placeholder="$t(field?.placeholder ?? '')"
            :class="defaultInputClass"
            >
            <div :class="defaultIconWrapperClass">
                <el-icon v-if="field?.tooltipText && field?.tooltipText !== ''" :data-tooltip-target="'tooltip-icon-input-'+ _id" type="button" :color="field?.iconColor ?? 'silver'" :size="field?.iconSize ?? '18'"><QuestionFilled :class="iconClass" /></el-icon>
            </div>
            <label :class="defaultLabelClass" :for="'floating-input-filed-' + _id">{{$t(field.label ?? field.placeholder ?? '')}}</label>
            <div v-if="field.tooltipText && field.tooltipText !== ''" :id="'tooltip-icon-input-'+ _id" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                {{ $t(field?.tooltipText) }}
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
    </div>
</template>