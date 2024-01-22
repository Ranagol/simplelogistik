<template>
    <Head title="Dashboard" />
    <Tabs :content="content"/>
    <TableWithContent />
</template>

<script setup>
import TableWithContent from "@/Components/Tables/TableWithContent.vue";
import Tabs from "@Components/Tabs/Tabs.vue"
import GeneralData from "@Contents/Orders/GeneralData.vue";
import GeneralData2 from "@Contents/Orders/GeneralData2.vue";
import GeneralData3 from "@Contents/Orders/GeneralData3.vue";
import { Histogram } from "@element-plus/icons-vue"

const content = [
    {
        title: "Basis Informationen",
        target: "base",
        content: GeneralData,
        icon: Histogram,
        active: true
    },{
        title: "Sendungsdaten",
        target: "base2",
        content: GeneralData2,
        icon: Histogram
    },{
        title: "Auftragsverwaltung",
        target: "base3",
        content: GeneralData3,
        icon: Histogram
    },{
        title: "Sendungsverfolgung",
        target: "base4",
        content: GeneralData2,
        icon: Histogram
    },{
        title: "Änderungsverlauf",
        target: "base5",
        content: GeneralData,
        icon: Histogram
    }
]
</script>

<style>
</style>


