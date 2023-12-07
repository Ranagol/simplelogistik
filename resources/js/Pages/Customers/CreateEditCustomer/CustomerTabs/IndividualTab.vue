<template>
    <slot name="buttonSubmitTab"></slot>
    
    <!-- :rules="rules" -->
    <el-form
        ref="ruleFormRef"
        :model="data.customer"
        label-position="left"
        label-width="150px"
    >
        <el-form-item
            label="Auto book as private"
            prop="auto_book_as_private"
            :label-width="data.labelWidth"
        >
            <el-checkbox
                v-model="data.customer.auto_book_as_private"
            />
        </el-form-item>

        <el-form-item
            label="Dangerous goods"
            prop="dangerous_goods"
            :label-width="data.labelWidth"
        >
            <el-checkbox
                v-model="data.customer.dangerous_goods"
            />
        </el-form-item>

        <el-form-item
            label="Bussiness customer"
            prop="bussiness_customer"
            :label-width="data.labelWidth"
        >   
            <el-checkbox
                v-model="data.customer.bussiness_customer"
            />
        </el-form-item>

        <el-form-item
            label="Debt collection"
            prop="debt_collection"
            :label-width="data.labelWidth"
        >
            <el-checkbox
                v-model="data.customer.debt_collection"
            />
        </el-form-item>

        <el-form-item
            label="Direct debit"
            prop="direct_debit"
            :label-width="data.labelWidth"
        >   
            <el-checkbox
                v-model="data.customer.direct_debit"
            />
        </el-form-item>

        <el-form-item
            label="Manual collective invoicing"
            prop="manual_collective_invoicing"
            :label-width="data.labelWidth"
        >   
            <el-checkbox
                v-model="data.customer.manual_collective_invoicing"
            />
        </el-form-item>

        <el-form-item
            label="Only paypal sofort amazon vorkasse"
            prop="only_paypal_sofort_amazon_vorkasse"
            :label-width="data.labelWidth"
        >   
            <el-checkbox
                v-model="data.customer.only_paypal_sofort_amazon_vorkasse"
            />
        </el-form-item>

        <el-form-item
            label="Private customer"
            prop="private_customer"
            :label-width="data.labelWidth"
        >
            <el-checkbox
                v-model="data.customer.private_customer"
            />
        </el-form-item>

        <el-form-item
            label="Invoice customer"
            prop="invoice_customer"
            :label-width="data.labelWidth"
        >
            <el-checkbox
                v-model="data.customer.invoice_customer"
            />
        </el-form-item>

        <el-form-item
            label="Poor payment morale"
            prop="poor_payment_morale"
            :label-width="data.labelWidth"
        >
            <el-checkbox
                v-model="data.customer.poor_payment_morale"
            />
        </el-form-item>

        <el-form-item
            label="Can login"
            prop="can_login"
            :label-width="data.labelWidth"
        >
            <el-checkbox
                v-model="data.customer.can_login"
            />
        </el-form-item>

        <!-- EL-SELECT FIELDS START HERE -->

        <el-form-item
            label="Customer type"
            prop="customer_type"
            :label-width="data.labelWidth"
        >
            <el-select
                v-model="data.customer.customer_type"
                clearable
                @change="update()"
            >
                <el-option
                    v-for="(item, index) in props.selectOptions.customerTypes"
                    :key="index"
                    :label="item"
                    :value="item"
                ></el-option>
            </el-select>
                
                <div
                    v-if="props.errors.address_type"
                    v-text="props.errors.address_type"
                    class="text-red-500 text-xs mt-1"
                ></div>
        </el-form-item>

        <el-form-item
            label="Invoice dispatch"
            prop="invoice_dispatch"
            :label-width="data.labelWidth"
        >
            <el-select
                v-model="data.customer.invoice_dispatch"
                clearable
                @change="update()"
            >
                <el-option
                    v-for="(item, index) in props.selectOptions.invoiceDispatches"
                    :key="index"
                    :label="item"
                    :value="item"
                ></el-option>
            </el-select>
                
                <div
                    v-if="props.errors.address_type"
                    v-text="props.errors.address_type"
                    class="text-red-500 text-xs mt-1"
                ></div>
        </el-form-item>

        <el-form-item
            label="Invoice shipping method"
            prop="invoice_shipping_method"
            :label-width="data.labelWidth"
        >
            <el-select
                v-model="data.customer.invoice_shipping_method"
                clearable
                @change="update()"
            >
                <el-option
                    v-for="(item, index) in props.selectOptions.invoiceShippingMethods"
                    :key="index"
                    :label="item"
                    :value="item"
                ></el-option>
            </el-select>
                
                <div
                    v-if="props.errors.address_type"
                    v-text="props.errors.address_type"
                    class="text-red-500 text-xs mt-1"
                ></div>
        </el-form-item>

        <el-form-item
            label="Payment method"
            prop="payment_method"
            :label-width="data.labelWidth"
        >
            <el-select
                v-model="data.customer.payment_method"
                clearable
                @change="update()"
            >
                <el-option
                    v-for="(item, index) in props.selectOptions.paymentMethods"
                    :key="index"
                    :label="item"
                    :value="item"
                ></el-option>
            </el-select>
                
                <div
                    v-if="props.errors.address_type"
                    v-text="props.errors.address_type"
                    class="text-red-500 text-xs mt-1"
                ></div>
        </el-form-item>

    </el-form>
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';



let props = defineProps({

    // The customer object.
    modelValue: {
        type: Object,
        required: true
    },

    // validation errors
    errors: Object,

    /**
     * These are the possibly selectable options for the el-select in customer create or edit form.
     * The options are fetched from the backend.
     */
    selectOptions: Object,
});

let data = reactive({
    customer: props.modelValue,

    /**
     * The label width for the el-form-item. This is used to make the label text and the input field
     * aligned. The distance between the label and the input field.
     */
    labelWidth: '260px',
});

/**
 * This does the customer data synchronization with the parent CreateEditBase component. With
 * v-model magic. This is not sending a signal for saving the customer! Just the customer.
 */
const emit = defineEmits(['update:modelValue']);
function handleChange(){
    emit('update:modelValue', data.customer);
}



</script>

<style scoped>
</style>