<template>
    <div class="overflow-hidden bg-white rounded-lg shadow">
        <div class="px-4 py-5 sm:p-6">
            <Tabs :content="tabContent" />
        </div>
    </div>
</template>

<script setup>
    import Tabs from '@/Components/Tabs/Tabs.vue';
    import OrderDetailsTab from './Tabs/OrderDetailsTab.vue';
    import ShippingInfoTab from './Tabs/ShippingInfoTab.vue';
    import OrderManagementTab from './Tabs/OrderManagementTab.vue';
    import OrderTrackingTab from './Tabs/OrderTrackingTab.vue';
    import OrderHistoryTab from './Tabs/OrderHistoryTab.vue';

    import { Histogram } from "@element-plus/icons-vue";
    import { initFlowbite } from 'flowbite';
    import { onMounted } from 'vue';

    onMounted(() => {
        initFlowbite();
    })


    const props = defineProps({
        record: {
            type: Object,
            required: true
        }
    })

    const tabContent = [
    {
        title: 'labels.tabs.order-base',
        target: "order-base",
        content: OrderDetailsTab,
        _data: props.record,
        icon: Histogram,
        active: true
    },{
        title: 'labels.tabs.shipping-info',
        target: "shipping-info",
        content: ShippingInfoTab,
        _data: props.record,
        icon: Histogram
    },{
        title: 'labels.tabs.management',
        target: "management",
        content: OrderManagementTab,
        _data: props.record,
        icon: Histogram
    },{
        title: 'labels.tabs.tracking',
        target: "tracking",
        content: OrderTrackingTab,
        _data: props.record,
        icon: Histogram
    },{
        title: 'labels.tabs.history',
        target: "history",
        content: OrderHistoryTab,
        _data: props.record,
        icon: Histogram
    }
]    

</script>

<script>

</script>