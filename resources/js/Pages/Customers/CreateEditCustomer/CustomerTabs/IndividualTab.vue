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

        


    </el-form>
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';


// 'auto_book_as_private' => 'boolean',
// 'dangerous_goods' => 'boolean',
// 'bussiness_customer' => 'boolean',
// 'debt_collection' => 'boolean',
// 'direct_debit' => 'boolean',
// 'manual_collective_invoicing' => 'boolean',
// 'only_paypal_sofort_amazon_vorkasse' => 'boolean',
// 'private_customer' => 'boolean',
// 'invoice_customer' => 'boolean',
// 'poor_payment_morale' => 'boolean',
// 'can_login' => 'boolean',

let props = defineProps({
    modelValue: {
        type: Object,
        required: true
    },
    errors: Object,
});

let data = reactive({
    customer: props.modelValue,
    labelWidth: '260px',// for the el-form-item label width
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