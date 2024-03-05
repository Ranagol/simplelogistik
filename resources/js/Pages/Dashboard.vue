<script setup>
    import Page from '@/Components/Page.vue';
    import SimpleTable from '@/Components/Tables/SimpleTable.vue';
    import config from "@/config/Pages/Dashboard/_index";
    import { store as useStore } from "@/Stores/dashboardStore";
    const store = useStore();
    const orders = store.getOrders();

    import orderHeaderConfig from "@/config/Tables/_dashboard_orderHeaders"; 
    import orderSearchConfig from "@/config/SearchFilters/orderSearch"; 
</script>


<template>
    <Head :title="$t('Dashboard')"></Head>
    <div class="grid gap-4 p-3 rounded-md">
        <div class="px-2 bg-white rounded-md">
            <SimpleTable configName="dashboard-orders" :showFilter="true" :showSearch="false" :searchConfig="orderSearchConfig" :tableConfig="orderHeaderConfig" :content="orders" />
        </div>
    </div>
</template>