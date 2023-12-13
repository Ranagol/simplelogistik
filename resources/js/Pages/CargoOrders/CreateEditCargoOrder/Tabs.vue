<template>
    <el-tabs
        type="border-card"
        stretch
    >
        <el-tab-pane
            label="Order data"
        >
            <DataTab
                v-model:cargoOrder="data.cargoOrder"
                :errors="props.errors"
                :mode="props.mode"
                @submit="submit"
                @destroy="destroy"
            />
        </el-tab-pane>

        <el-tab-pane
            label="Tracking"
        >
            <TrackingTab
                v-model:cargoOrder="data.cargoOrder"
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
                v-model:cargoOrder="data.cargoOrder"
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
                v-model:cargoOrder="data.cargoOrder"
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
import DataTab from './CargoOrderTabs/DataTab.vue';
import TrackingTab from './CargoOrderTabs/TrackingTab.vue';
import DocumentsTab from './CargoOrderTabs/DocumentsTab.vue';
import InfoToolTab from './CargoOrderTabs/InfoToolTab.vue';

const props = defineProps({

    /**
     * The cargoOrder object.
     */
    cargoOrder: {
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
     * The cargoOrder object.
     */
    cargoOrder: props.cargoOrder
});

const emit = defineEmits(['submit', 'update:cargoOrder', 'destroy']);

/**
 * Watch for changes in the cargoOrder object. In case of any change, it will immediatelly
 * update the parent component's cargoOrder object. We must use here watcher, because of the tabs.
 * In addresses, where there are no tabs, no watchers is used.
 */
 watch(
    () => data.cargoOrder, 
    (newValue, oldValue) => {
        // console.log('data.cargoOrder changed', newValue, oldValue);
        emit('update:cargoOrder', newValue);
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