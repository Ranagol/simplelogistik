<template>
    <el-tabs
        type="border-card"
        stretch
    >
        <el-tab-pane
            label="Order data"
        >
            <DataTab
                v-model:order="data.order"
                :errors="props.errors"
                :mode="props.mode"
                :selectOptions="props.selectOptions"
                @submit="submit"
                @destroy="destroy"
            />
        </el-tab-pane>

        <el-tab-pane
            label="Tracking"
        >
            <TrackingTab
                v-model:order="data.order"
                :errors="props.errors"
                :mode="props.mode"
                @submit="submit"
                @destroy="destroy"
            />
        </el-tab-pane>

        <el-tab-pane
            label="Documents"
        >
            <DocumentsTab
                v-model:order="data.order"
                :errors="props.errors"
                :mode="props.mode"
                @submit="submit"
                @destroy="destroy"
            />
        </el-tab-pane>

        <el-tab-pane
            label="Info tool"
        >
            <InfoToolTab
                v-model:order="data.order"
                :errors="props.errors"
                :mode="props.mode"
                @submit="submit"
                @destroy="destroy"
            />
        </el-tab-pane>

        <el-tab-pane
            label="Order history"
        >
            <OrderHistoryTab
                v-model:order="data.order"
                :errors="props.errors"
                :mode="props.mode"
                @submit="submit"
                @destroy="destroy"
            />
        </el-tab-pane>

    </el-tabs>
</template>

<script setup>
import { reactive, ref, onBeforeMount, watch, computed } from 'vue';
import _ from 'lodash';
import DataTab from './orderTabs/DataTab/DataTab.vue';
import TrackingTab from './orderTabs/TrackingTab.vue';
import DocumentsTab from './orderTabs/DocumentsTab.vue';
import InfoToolTab from './orderTabs/InfoToolTab.vue';
import OrderHistoryTab from './orderTabs/OrderHistoryTab.vue';

const props = defineProps({

    /**
     * The order object.
     */
    order: {
        type: Object,
        required: true
    },

    /**
     * mode is either 'create' or 'edit'. This is decided in the controller. This component will
     * behave differently depending on which mode is it.
     */
    mode: {
        type: String,
        required: true
    },

    /**
     * The errors object that is sent from the backend, and contains the validation errors.
     */
    errors: Object,

    /**
     * These are the possibly selectable options for the el-select in customer create or edit form.
     * The options are fetched from the backend.
     */
    selectOptions: Object,
});

const data = reactive({

    /**
     * The order object.
     */
    order: props.order
});

const emit = defineEmits(['submit', 'update:order', 'destroy']);

/**
 * Watch for changes in the order object. In case of any change, it will immediatelly
 * update the parent component's order object. We must use here watcher, because of the tabs.
 * In addresses, where there are no tabs, no watchers is used.
 */
 watch(
    () => data.order, 
    (newValue, oldValue) => {
        // console.log('data.order changed', newValue, oldValue);
        emit('update:order', newValue);
    },
    { deep: true }
);

const submit = () => {
    emit('submit');
}  

const destroy = () => {
    emit('destroy');
}




</script>