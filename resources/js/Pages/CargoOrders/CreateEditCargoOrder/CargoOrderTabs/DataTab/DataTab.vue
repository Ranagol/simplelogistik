<template>
    <el-form
        ref="ruleFormRef"
        :model="data.cargoOrder"
        label-position="top"
        label-width="150px"
    >   

        <!-- HEADER WITH DELETE AND SUBMIT BUTTON -->
        <Header
            v-model:cargoOrder="data.cargoOrder"
            :errors="props.errors"
            :mode="props.mode"
            @submit="submit"
            @destroy="destroy"
        />

        <!-- TITLE -->
        <Title 
            title="Cargo order data"
        />


        <!-- DETAILS -->
        <el-card class="box-card">
            <div class="flex flex-row">

                <!-- YOUR REFERENCE -->
                    <el-form-item
                    label="Your reference"
                    prop="customer_reference"
                >
                    <el-input
                        v-model="data.cargoOrder.customer_reference"
                        clearable
                        placeholder="Your reference"
                    />
                </el-form-item>

                <!-- ORDER DATE -->
                <el-form-item
                    label="Order date"
                    prop="order_date"
                    class="ml-6"
                >12.12.2012???</el-form-item>

                <!-- Imported via -->
                <el-form-item
                    label="Imported via"
                    prop="imported_via"
                    class="ml-6"
                >Manually?????</el-form-item>

                <!-- Import timestamp -->
                <el-form-item
                    label="Import timestamp"
                    prop="import_timestamp"
                    class="ml-6"
                >12.12.2012.???????</el-form-item>

                <!-- Status -->
                <el-form-item
                    label="Status"
                    prop="status"
                    class="ml-6"
                >Draft????</el-form-item>
            </div>

            



        </el-card>




        <pre>{{ JSON.stringify(props.cargoOrder, null, 2) }}</pre>  

    </el-form>


</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import _ from 'lodash';
import Header from './Header.vue';
import Title from '@/Shared/Title.vue';

let props = defineProps({

    /**
     * The carogOrder object.
     */
    cargoOrder: {
        type: Object,
        required: true
    },

    /**
     * The errors object that is sent from the backend, and contains the validation errors.
     */
    errors: Object,

    /**
     * mode is either 'create' or 'edit'. This is decided in the controller. This component will
     * behave differently depending on which mode is it.
     */
    mode: {
        type: String,
        required: true
    },
});

let data = reactive({
    cargoOrder: props.cargoOrder
});

/**
 * This does the customer data synchronization with the parent CreateEditBase component. With
 * v-model magic. This is not sending a signal for saving the customer! Just the data.customer.
 */
 const emit = defineEmits(['update:cargoOrder', 'submit', 'destroy']);

/**
 * Here we only update the parent's customer, using v-model magic. This is not sending a signal.
 */
 const update = () =>{
    emit('update:modelValue', data.customer);
}

const submit = () => {
    emit('submit');
}

const destroy = () => {
    emit('destroy');
}
</script>