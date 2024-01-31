<template>
    <h2 @click="onToggleSection(props.section.key)" class="w-full mb-4 text-lg font-bold text-gray-900 cursor-pointer dark:text-white"><span>{{ props.title }}</span> <el-icon class="transition-all duration-200" :class="{'rotate-180' : props.sectionActive}"><ArrowDown /></el-icon></h2>
    <section class="py-3 mb-4" :class="{'border-b': props.sectionActive}">
        <div class="grid grid-cols-2 gap-4 xl:grid-cols-4" :class="{'hidden': !sectionActive}">
            <div class="relative grid col-span-4 p-4 rounded bg-gray-50">
                {{ $t('labels.order-customer-data') }}
                <div class="text-corporate-400">
                    {{  tabData?.company_name }}
                    <p v-if="tabData?.company_name"><span :class="{'font-bold': address.company_name}">{{ tabData?.company_name }}</span></p>
                    <p><span>{{ tabData?.first_name }} {{ tabData?.last_name }}</span></p>
                    <p><span>{{ tabData?.street }} {{ tabData?.house_number }}</span></p>
                    <p><span>{{ tabData?.zip_code }} {{ tabData?.city }}</span></p>
                    <p><span>{{ tabData?.state }} {{ tabData?.country?.country_name }}</span></p>
                </div>
            </div>
            <div class="relative p-4 pt-8 rounded bg-gray-50" v-for="address in tabData">
                <span v-if="address.address_type === 'labels.address-delivery'" class="absolute block px-2 text-[12px] text-white rounded-sm top-2 right-2 bg-primary-600">
                    {{ $t(address.address_type) }}
                </span>
                <span v-else="address.address_type === 'labels.address-delivery'" class="absolute block px-2 text-[12px] text-orange-900 bg-orange-300 rounded-sm top-2 right-2">
                    {{ $t(address.address_type) }}
                </span>
                <div class="text-1">
                    <p v-if="address.company_name"><span :class="{'font-bold': address.company_name}">{{ address.company_name }}</span></p>
                    <p><span>{{ address.first_name }} {{ address.last_name }}</span></p>
                    <p><span>{{ address.street }} {{ address.house_number }}</span></p>
                    <p><span>{{ address.zip_code }} {{ address.city }}</span></p>
                    <p><span>{{ address.state }} {{ address.country.country_name }}</span></p>
                </div>
                <div >
                    <p>Abholung zwischen</p>
                    <p>
                        {{ address.pickup_date_from }} - {{ address.pickup_date_to }}
                    </p>
                    <p>Zustellung zwischen</p>
                    <p>
                        {{ address.delivery_date_from }} - {{ address.delivery_date_to }}
                    </p>
                    <p>Avis</p>
                    <p>SMS {{ address?.avis?.avis_sms ?? "nein"}}</p>
                    <p>Anruf {{ address?.avis?.avis_phone ?? "nein" }}</p>               
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ArrowDown } from '@element-plus/icons-vue';
import { initFlowbite } from 'flowbite';
import { onMounted } from 'vue';

const props = defineProps({
    tabData: {
        type: Array,
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

const onToggleSection = (section) => {
    props.onToggleSection(section);
}

onMounted(() => {
    initFlowbite();
})

</script>
