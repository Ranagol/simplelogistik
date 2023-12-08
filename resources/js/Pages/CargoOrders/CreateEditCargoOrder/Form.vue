<template>
    <el-form
        ref="ruleFormRef"
        :model="data.cargoOrderData"
        label-position="left"
        :rules="rules"
        label-width="150px"
    >

        <!-- HEADER -->
        <div class="flex flex-row mb-2 justify-between">
            
            <!-- ADDRESS HEADER WITH BASIC ADDRESS DATA -->
            <Header
                :record="data.cargoOrderData"
                :mode="props.mode"
                :headerText="headerText"
            />
            
            <!-- SUBMIT BUTTON -->
            <el-form-item>
                <el-button
                    @click="submit"
                    type="primary"
                    name="button"
                >Submit</el-button>
            </el-form-item>

            <!-- DELETE BUTTON -->
            <el-form-item
                v-if="props.mode === 'edit'"
            >
                <el-button
                    @click="destroy"
                    type="danger"
                    name="button"
                >Delete</el-button>
            </el-form-item>
        </div>

        <!-- INTERNAL OID -->
        <el-form-item
            label="Internal oid"
            prop="internal_oid"
        >
            <el-input
                v-model="data.cargoOrderData.internal_oid"
                placeholder="Internal oid"
            ></el-input>
        </el-form-item>

        <!-- CUSTOMER -->
        <el-form-item
            label="Customer"
            prop="customer_id"
        >
            <el-select
                v-model="data.cargoOrderData.customer_id"
                placeholder="Customer"
            >
                <el-option
                    v-for="customer in data.customers"
                    :key="customer.id"
                    :label="customer.name"
                    :value="customer.id"
                ></el-option>
            </el-select>
        </el-form-item>

        <!-- CONTACT -->
        <el-form-item
            label="Contact"
            prop="contact_id"
        >
            <el-select
                v-model="data.cargoOrderData.contact_id"
                placeholder="Contact"
            >
                <el-option
                    v-for="contact in data.contacts"
                    :key="contact.id"
                    :label="contact.name"
                    :value="contact.id"
                ></el-option>
            </el-select>
        </el-form-item>

        <!-- START ADDRESS -->
        <el-form-item
            label="Start address"
            prop="start_address_id"
        >
            <el-select
                v-model="data.cargoOrderData.start_address_id"
                placeholder="Start address"
            >
                <el-option
                    v-for="address in data.addresses"
                    :key="address.id"
                    :label="address.name"
                    :value="address.id"
                ></el-option>
            </el-select>
        </el-form-item>

        <!-- TARGET ADDRESS -->
        <el-form-item
            label="Target address"
            prop="target_address_id"
        >
            <el-select
                v-model="data.cargoOrderData.target_address_id"
                placeholder="Target address"
            >
                <el-option
                    v-for="address in data.addresses"
                    :key="address.id"
                    :label="address.name"
                    :value="address.id"
                ></el-option>
            </el-select>
        </el-form-item>

        <!-- DESCRIPTION -->
        <el-form-item
            label="Description"
            prop="description"
        >
            <el-input
                v-model="data.cargoOrderData.description"
                placeholder="Description"
            ></el-input>
        </el-form-item>

        <!-- SHIPPING PRICE -->
        <el-form-item
            label="Shipping price"
            prop="shipping_price"
        >
            <el-input
                v-model="data.cargoOrderData.shipping_price"
                placeholder="Shipping price"
            ></el-input>
        </el-form-item>

        <!-- SHIPPING PRICE NETTO -->
        <el-form-item
            label="Shipping price netto"
            prop="shipping_price_netto"
        >
            <el-input
                v-model="data.cargoOrderData.shipping_price_netto"
                placeholder="Shipping price netto"
            ></el-input>
        </el-form-item>

        <!-- PICKUP DATE -->
        <el-form-item
            label="Pickup date"
            prop="pickup_date"
        >
            <el-date-picker
                v-model="data.cargoOrderData.pickup_date"
                type="date"
                placeholder="Pickup date"
                value-format="yyyy-MM-dd"
            ></el-date-picker>
        </el-form-item>

        <!-- DELIVERY DATE -->
        <el-form-item
            label="Delivery date"
            prop="delivery_date"
        >
            <el-date-picker
                v-model="data.cargoOrderData.delivery_date"
                type="date"
                placeholder="Delivery date"
                value-format="yyyy-MM-dd"
            ></el-date-picker>
        </el-form-item>
        
    </el-form>
</template>

<script setup>
import { reactive, ref, onBeforeMount, watch, computed } from 'vue';
import Header from '@/Shared/Crud/Header.vue';
import _ from 'lodash';


const props = defineProps({
    cargoOrder: {
        type: Object,
    },

    errors: {
        type: Object,
        required: true
    },

    mode: {
        type: String,
        required: true
    },

});

const data = reactive({
    cargoOrderData: props.cargoOrder || {},
    columns: [
        'id',
        'internal_oid',
        'customer_id',
        'contact_id',
        'start_address_id',
        'target_address_id',
        'description',
        'shipping_price',
        'shipping_price_netto',
        'pickup_date',
        'delivery_date',
    ],
});

const headerText = computed(() => {
    //_.get() returns undefined if the path doesn't exist. Which is faulty.
    if (props.mode === 'edit' && _.get(props.cargoOrder, 'id')) {
        return _.capitalize(props.mode) + ` cargoOrder id: ${props.cargoOrder.id}`;
    } else {
        return _.capitalize(props.mode) + ' new cargoOrder';
    }
});

const emit = defineEmits(['update:cargoOrder', 'submit', 'destroy']);

const update = () => {
    emit('update:cargoOrder', data.cargoOrderData);
}

const submit = () => {
    emit('submit');
}

//It is called destroy, because delete is a reserved word in JS
const destroy = () => {
    emit('destroy');
}

</script>