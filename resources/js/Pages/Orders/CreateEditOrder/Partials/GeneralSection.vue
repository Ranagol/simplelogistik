    <template>
    <h2 @click="onToggleSection(props.section.key)" class="w-full mb-4 text-lg font-semibold text-gray-900 cursor-pointer dark:text-white"><span>{{ props.title }}</span> <el-icon class="transition-all duration-200" :class="{'rotate-180' : props.sectionActive}"><ArrowDown /></el-icon></h2>
    <section class="py-3 mb-4" :class="{'border-b': props.sectionActive, 'py-0 mb-0': !sectionActive}">
        <div class="grid gap-4" :class="{'hidden': !sectionActive}">
            <!-- <pre>{{ tabData }}</pre> -->
            <!-- Type of Transport -->
            <!-- TODO: (Andor) make types of transport to be fed from backend database -->
            <div class="grid grid-flow-col grid-cols-2 gap-4">
                <CustomDropdown 
                    :floating="true" 
                    labelText="labels.type_of_transport"
                    id="type_of_transport"
                    :value="generalData.type_of_transport" 
                    :updateValue="(value) => {generalData.type_of_transport = value}" 
                    :options="getTypesOfTransport()" 
                    />
                    
                <CustomDropdown 
                    :floating="true" 
                    labelText="labels.status"
                    id="order_status"
                    :value="generalData.status" 
                    :updateValue="(value) => {generalData.status = value}" 
                    :options="getStatuses()" 
                    />
            </div>
            <div class="grid grid-flow-col gap-4">
                <IconTooltipInput :value="data?.partner?.name ?? 'Kein Partner'" placeholder="labels.partner" :keyup="(a) => console.log(a.target.value)" tooltipText="Geben Sie den Partner an" />
                <IconTooltipInput :value="tabData?.origin" placeholder="labels.origin" :keyup="(a) => console.log(a.target.value)" tooltipText="Geben Sie den Partner an" />
                <IconTooltipInput :value="tabData?.customer_reference" placeholder="labels.customer_reference" :keyup="(a) => console.log(a.target.value)"/>
                <IconTooltipInput :value="tabData?.details?.distance_km" placeholder="labels.distance_km" :keyup="(a) => console.log(a.target.value)"/>
            </div>
            <div class="grid grid-flow-col gap-4">
                <IconTooltipInput :value="tabData?.details?.duration_minutes" placeholder="labels.distance_duration" :keyup="(a) => console.log(a.target.value)" tooltipText="Geben Sie den Partner an" />
                <IconTooltipInput :value="tabData?.details?.calculation_model_name" placeholder="labels.calculation_model_name" :keyup="(a) => console.log(a.target.value)"/>
            </div>
            <div class="grid grid-flow-col gap-4">
                <IconTooltipInput :value="tabData?.details?.particularities" placeholder="labels.particularities" :keyup="(a) => console.log(a.target.value)" tooltipText="Geben Sie den Partner an" />
                <IconTooltipInput :value="tabData?.details?.description_of_transport" placeholder="labels.description_of_transport" :keyup="(a) => console.log(a.target.value)"/>
            </div>
        </div>
    </section>
</template>
<script setup>
import CustomDropdown from '@/Components/Dropdowns/CustomDropdown.vue';
import IconTooltipInput from '@/Components/Inputs/IconTooltipInput.vue';

import { ArrowDown, QuestionFilled } from '@element-plus/icons-vue';
import { initFlowbite } from 'flowbite';
import { reactive } from 'vue';
import { onMounted } from 'vue';


const props = defineProps({
    tabData: {
        type: Object,
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

var generalData = reactive({
    type_of_transport: null,
    status: null
})

const data = props.tabData

const getTypesOfTransport = () => {
    // TODO: fetch types of transport from backend
    return [
        { key: 1, name: 'labels.transport-types.package' },
        { key: 2, name: 'labels.transport-types.sea-freight' },
        { key: 3, name: 'labels.transport-types.air-freight' },
        { key: 4, name: 'labels.transport-types.bulky-goods' },
        { key: 5, name: 'labels.transport-types.pal' },
        { key: 6, name: 'labels.transport-types.e-pal' },
        { key: 7, name: 'labels.transport-types.ltl-ftl' },
        { key: 8, name: 'labels.transport-types.courier' },
        { key: 9, name: 'labels.transport-types.other' }
    ]
}
const getStatuses = () => {
    // TODO: fetch types of transport from backend
    return [
        { key: 1, name: 'labels.order-status-open' },
        { key: 2, name: 'labels.order-status-delivered' }
    ]
}

const onToggleSection = (section) => {
    props.onToggleSection(section);
}

onMounted(() => {
    initFlowbite();
})

</script>
