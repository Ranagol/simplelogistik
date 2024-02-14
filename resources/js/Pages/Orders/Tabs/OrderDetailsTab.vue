<template>
    <section class="bg-white dark:bg-gray-900">
        <div class="relative flex justify-between gap-8 px-3 py-4">
            <div class="w-full">
                <GeneralSection 
                    :title="$t('labels.section-general')"
                    :onToggleSection="toggleSection"
                    :section="sections.general" 
                    :sectionActive="sections.general.state"
                    :tabData="tabData ?? {}"
                />
                <AddressSection 
                    :title="$t('labels.section-address')"
                    :onToggleSection="toggleSection"
                    :section="sections.address" 
                    :sectionActive="sections.address.state"
                    :tabData="tabData ?? {}"
                />
                <ParcelsSection 
                    :title="$t('labels.section-parcels')"
                    :onToggleSection="toggleSection"
                    :section="sections.parcels" 
                    :sectionActive="sections.parcels.state"
                    :data="tabData?.parcels ?? [{}]"
                />
                <FinancesSection 
                    :title="$t('labels.section-finances')"
                    :onToggleSection="toggleSection"
                    :section="sections.finances" 
                    :sectionActive="sections.finances.state"
                    :data="tabData?.finances ?? {}"
                />
                <VehicleSection 
                    :title="$t('labels.section-vehicles')"
                    :onToggleSection="toggleSection"
                    :section="sections.vehicles" 
                    :sectionActive="sections.vehicles.state"
                    :data="tabData?.vehicles ?? {}"
                />
            </div>
             <div class="relative flex flex-col mt-14 w-[380px] gap-4 align-top">
                <div class="grid gap-2 p-3 bg-white border rounded-md shadow-md border-slate-100">
                    <div class="mb-4">
                        <h3 class="grid justify-between grid-flow-col text-lg font-bold text-gray-900">{{ $t("labels.order") }} <span>{{ tabData.details?.order_number }}</span></h3>
                    </div>
                    <div class="grid justify-between grid-flow-col">
                        <span class="text-gray-900">{{ $t('labels.customer-id') }}</span>
                        <span><a class="underline hover:text-corporate-500 hover:font-semibold" :href="route('customers.show', tabData.customer?.id )">{{ tabData.customer?.id }}</a></span>
                    </div>
                    <div class="grid justify-between grid-flow-col">
                        <span class="text-gray-900">{{ $t('labels.order-date') }}</span>
                        <span>{{ parseDate(tabData.order_date) }}</span>
                    </div>
                    <div class="grid justify-between grid-flow-col">
                        <span class="text-gray-900">{{ $t('labels.month_and_year') }}</span>
                        <span class="text-red-500">{{ parseDate(tabData.month_and_year) }}</span>
                    </div>
                    <div class="grid justify-between grid-flow-col">
                        <span class="text-gray-900">{{ $t('labels.cancelled') }}</span>
                        <span>{{ parseDate(tabData.details.date_of_cancellations) }}</span>
                    </div>
                </div>
                <div class="grid gap-2 p-3 bg-white border rounded-md shadow-md border-slate-100">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-900">{{ $t("labels.order-finance-summary") }}</h3>
                    </div>
                    <div class="grid justify-between grid-flow-col">
                        <span class="text-gray-900">{{ $t('labels.selling-price') }}</span>
                        <span>{{ tabData.details.price_gross + " " + (tabData?.currency_sign ?? "€") }}</span>
                    </div>
                    <div class="grid justify-between grid-flow-col">
                        <span class="text-gray-900">{{ $t('labels.provision') }}</span>
                        <span>{{ tabData.provision }} %</span>
                    </div>
                    <div class="grid justify-between grid-flow-col">
                        <span class="text-gray-900">{{ $t('labels.buying-price') }}</span>
                        <span>{{ tabData.purchase_price + " " + (tabData?.currency_sign ?? "€")}}</span>
                    </div>
                    <div class="grid justify-between grid-flow-col">
                        <span class="text-gray-900">{{ $t('labels.profit') }}</span>
                        <span>
                            {{ (tabData.details.price_gross - (tabData.details.price_gross * tabData?.provision) - tabData.purchase_price).toFixed(2) }} {{ tabData?.currency_sign ?? "€" }}</span>
                    </div>
                    <div class="grid justify-between grid-flow-col pt-2 mt-2 border-t">
                        <span class="text-gray-900">{{ $t('labels.payment_method') }}</span>
                        <span>{{ tabData.payment_method }}</span>
                    </div>

                </div>
            </div>
        </div>
    </section> 
</template>

<script setup>

import { onMounted, reactive } from 'vue';
import { initFlowbite } from 'flowbite';
import moment from 'moment';
import GeneralSection from './../Partials/GeneralSection.vue';
import AddressSection from './../Partials/AddressSection.vue';
import ParcelsSection from './../Partials/ParcelsSection.vue';
import FinancesSection from './../Partials/FinancesSection.vue';
import VehicleSection from './../Partials/VehicleSection.vue';

onMounted(() => {
    initFlowbite();
})  

const storedSettings = sessionStorage.getItem("order-details-section-state");
if(storedSettings !== undefined && storedSettings !== null) {
    var settings = JSON.parse(storedSettings);
} else {
    var settings =  {
        general: {
            key: 'general', 
            state: true
        },
        address: {
            key: 'address', 
            state: false
        },
        parcels: {
            key: 'parcels', 
            state: false
        },
        finances: {
            key: 'finances', 
            state: false
        },
        vehicles: {
            key: 'vehicles', 
            state: false
        },
    }
}

const props = defineProps({
    tabData: {
        type: Object,
        required: true
    }
});

const tabData = props.tabData.data;

const sections = reactive( settings );

const parseDate = (date, withTimeString = false) => {
    return date;
    // return moment.moment(date).format('DD.MM.YYYY' + (withTimeString ? ' HH:mm' : '')).toString();
}

const toggleSection = (section) => {
    sections[section].state = !!!sections[section].state;
    sessionStorage.setItem("order-details-section-state", JSON.stringify(sections));
}

</script>

