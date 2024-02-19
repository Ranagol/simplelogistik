<template>
    <h2 @click="onToggleSection(props.section.key)" class="w-full mb-4 text-lg font-bold text-gray-900 cursor-pointer dark:text-white"><span>{{ props.title }}</span> <el-icon class="transition-all duration-200" :class="{'rotate-180' : props.sectionActive}"><ArrowDown /></el-icon></h2>
    <section class="py-3 mb-4" :class="{'border-b': props.sectionActive}">
        <div class="grid grid-cols-2 gap-4 xl:grid-cols-4" :class="{'hidden': !sectionActive}">
            <div class="relative grid col-span-4 p-4 rounded bg-gray-50">
                <span class="font-bold text-corporate-700">{{ $t('labels.order-client-informations') }}</span>
                <div class="mt-3">
                    <p v-if="tabData?.customer?.company_name"><span :class="{'font-bold': tabData?.customer?.company_name}">{{ tabData?.customer?.company_name }}</span></p>
                    <p><span>{{ tabData?.customer?.first_name }} {{ tabData?.customer?.last_name }}</span></p>
                    <p><span>{{ tabData?.customer?.headquarter?.street }} {{ tabData?.customer?.headquarter?.house_number }}</span></p>
                    <p><span>{{ tabData?.customer?.headquarter?.zip_code }} {{ tabData?.customer?.headquarter?.city }}</span></p>
                    <p><span>{{ tabData?.customer?.headquarter?.state }} {{ tabData?.country?.headquarter?.country_name }}</span></p>
                </div>
            </div>
            <div class="relative p-4 pt-8 rounded bg-gray-50" v-for="address in tabData?.addresses">
                <AddressBadge v-if="address.address_type === 'labels.address-delivery'" variant="delivery" :label="address.address_type" />
                <AddressBadge v-else-if="address.address_type === 'labels.address-pickup'" variant="pickup" :label="address.address_type" />
                <AddressBadge v-else-if="address.address_type === 'labels.address-billing'" variant="billing" :label="address.address_type" />
                <AddressBadge v-else-if="address.address_type === 'labels.address-headquarter'" variant="headquarter" :label="address.address_type" />
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
                    <p>{{ $t('labels.additional_options') }}</p>
                    <p>SMS {{ address?.avis?.avis_sms ?? "nein"}}</p>
                    <p>Anruf {{ address?.avis?.avis_phone ?? "nein" }}</p>               
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import AddressBadge from '@/Components/Badge/AddressBadge.vue';
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
