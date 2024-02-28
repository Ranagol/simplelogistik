<script setup>
    import { ArrowDown, ArrowUp, QuestionFilled } from '@element-plus/icons-vue';
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

    const _id = Math.random().toString(36).substring(7);

    var options = ref([])

    const getOptions = async () => {
        var DataHandler = new Data();
        let data = await DataHandler.getData(props.field.options)
        // let data = await Data.shared.getData(props.field.options)
        options.value = data.data
    }
    
    getOptions()
    const getDisplayData = (from, config, translator) => {
        let displayString = [];
        if(config.includes('|')){
            let keys = config.split('|')
            keys.map(key => {
                if(key.includes('translate:')){
                    var k = key.split(':')[1]
                    displayString.push(translator(from[k]))
                } else {
                    displayString.push(from[key])
                }
            })
        } else {
            if(config.includes('translate:')){
                var k = key.split(':')[1]
                displayString.push(translator(from[k]))
            } else {
                displayString.push(from[config])
            }
        }
        return displayString.join(' | ')
    }
    
    let open = ref(false)
    let selectedOption = ref(props.data[props.field.name] ?? false)
    
    const getActiveOption = () => {
        if(selectedOption.value){
            return options.value.find(option => option[props.field.match] == selectedOption.value)
        }
        return options.value.find(option => option[props.field.match] == props.data[props.field.name])
    }

    const selectOption = (option) => {
        selectedOption.value = option[props.field.match]
        open = ref(false)
        document.getElementById(_id + '-dropdown-button').click()
    }
    
</script>

<template>
        <div class="relative z-30 flex w-full">
            <button 
            class="grid justify-between w-full grid-flow-col p-3 py-2 border min-h-[42px] rounded-md place-items-center border-gray-300"
            :id="_id + '-dropdown-button'"
            :data-dropdown-toggle="_id + '-dropdown'"
            @click="open = !!!open"
            >   
            {{ getActiveOption() !== undefined ? getActiveOption()[field.displayKey] : "" }} <el-icon><ArrowDown v-if="!open"/><ArrowUp v-else/></el-icon>
            </button>
            <div class="absolute hidden w-full bg-white border rounded-md overflow-clip text-corporate-700" :id="_id + '-dropdown'">
                <div v-for="(option, index) in options"
                @click="() => {
                    store.update(field.name, option[field.match])
                    selectOption(option)
                }" 
                :key="index" 
                 class="p-2 px-4 cursor-pointer hover:text-white hover:bg-primary-800" 
                >
                    {{ getDisplayData(option, field.displayKey, $t) }}
                </div>
            </div>
        </div>
</template>