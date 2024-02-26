<script setup>
    import { QuestionFilled } from '@element-plus/icons-vue';
    import { ref, onMounted } from 'vue';
import Data from '../../lib/Data';
    const props = defineProps({
        store: Object,
        field: Object,
        data: Object,
        options: Array,
        useData: Boolean
    })

    const onInput = (name, value) => {
        props.store.update(name,value)
    }
    
    onMounted(() => {
        initFlowbite()
    })

    const defaultWrapperClass = 'relative ' + ' w-full ';
    const defaultLabelClass = '' + 'absolute ' + 'top-0 ' + 'start-1 ' + 'px-2 ' + 'text-[15px] ' + '-translate-y-1/2 ' + 'bg-white ' + 'peer-focus:text-corporate-700 ' + 'peer-placeholder-shown:top-1/2 ' + 'peer-focus:top-0 ' + 'transition-all ' + 'duration-300 ' + 'pointer-events-none ';
    const _id = Math.random().toString(36).substring(7);

    var options = ref([])

    const getOptions = async () => {
        var DataHandler = new Data();
        let data = await DataHandler.getData(props.field.options)
        // let data = await Data.shared.getData(props.field.options)
        options.value = data.data
    }
    
    getOptions()
    
</script>

<template>
        <div :class="defaultWrapperClass"> 
            <label :class="defaultLabelClass" :for="_id">{{ $t(field.label ?? field.placeholder) }}</label>
            <select :id="_id" class="w-full rounded-md" @change="e => store.update(field.name, e.target.value)" >
                <option v-for="(option, index) in options" :key="index" :value="option[field.name]" :selected="data[field.name] === option[field.match]">{{ option[field.displayKey] }}</option>
            </select>   
        </div>
</template>
