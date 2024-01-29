<template>
    <section class="bg-white dark:bg-gray-900">
        <div class="p-4 mx-auto" >
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
                :tabData="tabData?.addresses ?? [{}]"
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
    </section>
</template>

<script setup>
import GeneralSection from './../Partials/GeneralSection.vue';
import AddressSection from './../Partials/AddressSection.vue';
import ParcelsSection from './../Partials/ParcelsSection.vue';
import FinancesSection from './../Partials/FinancesSection.vue';
import VehicleSection from './../Partials/VehicleSection.vue';

import { reactive } from 'vue';

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
const sections = reactive( settings );

const toggleSection = (section) => {
    sections[section].state = !!!sections[section].state;
    sessionStorage.setItem("order-details-section-state", JSON.stringify(sections));
}
</script>