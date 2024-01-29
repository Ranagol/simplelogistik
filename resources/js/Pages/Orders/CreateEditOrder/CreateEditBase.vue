<template>
    <div class="overflow-hidden bg-white rounded-lg shadow">
        <div class="px-4 py-5 sm:p-6">
            <OrderDetailsTabs :content="tabContent" />
        </div>
    </div>
</template>

<script setup>
    import OrderDetailsTabs from '@/Components/Tabs/OrderDetailsTabs.vue';
    import OrderDetailsTab from './Tabs/OrderDetailsTab.vue';
    import DocumentsTab from './Tabs/DocumentsTab.vue';
    import OrderManagementTab from './Tabs/OrderManagementTab.vue';
    import OrderTrackingTab from './Tabs/OrderTrackingTab.vue';
    import OrderHistoryTab from './Tabs/OrderHistoryTab.vue';

    import { Bell, FolderOpened, Histogram, List, LocationInformation, Sort } from "@element-plus/icons-vue";
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
        icon: List,
        active: true
    },
    {
        title: 'labels.tabs.management',
        target: "management",
        content: OrderManagementTab,
        _data: props.record,
        icon: Bell
    },
    {
        title: 'labels.tabs.tracking',
        target: "tracking",
        content: OrderTrackingTab,
        _data: props.record,
        icon: LocationInformation
    },
    {
        title: 'labels.tabs.documents',
        target: "shipping-info",
        content: DocumentsTab,
        _data: props.record,
        icon: FolderOpened
    },
    {
        title: 'labels.tabs.history',
        target: "history",
        content: OrderHistoryTab,
        _data: props.record,
        icon: Sort
    }
]    

</script>

<script>

</script>