<template>

    <Head :title="props.mode"/>

    <!-- CREATE EDIT CARGO ORDER -->
    <Card>

        <!-- TITLE WITH CREATE AND CANCEL ORDER BUTTON -->
        <div class="flex flex-row justify-between">

            <!-- SIMPLE PAGE TITLE: THE ORDER NUMBER -->
            <Title 
                :title="data.title"
            />

            <div class="flex flex-row ">
                
                <!-- SUBMIT BUTTON -->
                <!-- Notice: whenever there is a 'submit emit from Header, the submit()
                is triggered, AND it receives the elformRef, which is the el-form
                itself. This is the secret for the FE validation.' -->
                <el-form-item>
                    <el-button
                        @click="triggerOrderSubmit"
                        type="primary"
                    >Save</el-button>
                </el-form-item>

                <!-- CANCEL ORDER BUTTON -->
                <el-form-item>
                    <el-button
                        @click="console.log('cancel order clicked, but no further steps are implemented yet')"
                        type="danger"
                        class="ml-4"
                    >Cancel</el-button>
                </el-form-item>
            </div>
        </div>
        
        <!-- ALL TABS -->
        <Tabs
            v-model:order="data.orderData"
            :errors="props.errors"
            :mode="props.mode"
            :selectOptions="props.selectOptions"
            @submit="submit"
            @destroy="destroy"
        />

        <!-- When scrolled all the way down, this widget will appear. Click on it will scroll the
        user back to the top of the page. -->
        <el-backtop :right="100" :bottom="100" />

    </Card>
</template>

<script setup>
import { reactive, ref, onBeforeMount, watch, computed } from 'vue';
import Card from '@/Shared/Card.vue';
import { useEdit } from '@/Use/useEdit';
import { useCreate } from '@/Use/useCreate';
import { useDestroy } from '@/Use/useDestroy';
import Tabs from './Tabs.vue';
import orderDummy from './orderDummy';
import orderEmpty from './orderEmpty';//don't delete this
import Title from '@/Shared/Title.vue';
import { useOrderStore } from '@/Stores/orderStore';

let orderStore = useOrderStore();

const props = defineProps({

    /**
     * The order object.
     */
    record: {
        type: Object,
        /**
         * The default value is a function that returns an empty order object.
         */
        default: () => (orderDummy),

    },

    /**
     * These are the possibly selectable options for the el-select in customer create or edit form.
     * The options are fetched from the backend.
     */
     selectOptions: Object,

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

});

const data = reactive({

    /**
     * The order object.
     */
    orderData: props.record,
    title: 'Order',
});

const subOrderType = computed(
    () => {
        if (props.record.pamyra_order !== null) {
            return 'pamyra_order';
        }
        if (props.record.native_order !== null) {
            return 'native_order';
        }
    }
);

/**
 * The submit button and the order form are in two separate components. When we click on the submit
 * button in this component, we want to trigger the submitting process in DataTab component which
 * has the el-form and the FE validation. If the FE validation is OK, then the DataTab component will
 * pass the submi triggering back here to this component. To make all this possible, we use Pinia for
 * component communication.
 */
const triggerOrderSubmit = () => {
    orderStore.triggerOrderSubmit = true;
    
}

/**
 * Reminder: this submit works for both create and edit. Depending on the mode, the submit will
 * either create or edit the order.
 */
const submit = () => {
    if (props.mode === 'edit') {
        //edits the order
        useEdit(
            'orders',
            data.orderData.id,
            data.orderData,
            'order',
            'record'
        );

    } else {
        //creates the order
        useCreate(
            'orders',
            data.orderData,
            'order',
            null,
            'http://localhost/orders'
        );
    }
}

const destroy = () => {
    console.log('destroy');
    //deletes the order
    useDestroy(
        `Address will be deleted. Continue?`,
        'orders',
        data.orderData.id,
        'order',
        null,
        'http://localhost/orders'
    );
}





</script>

<style scoped>

</style>
