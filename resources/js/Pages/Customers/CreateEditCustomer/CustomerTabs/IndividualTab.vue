<template>
    
    <el-form
        ref="ruleFormRef"
        :model="data.customer"
        label-position="left"
        label-width="150px"
    >
        <!-- HEADER -->
        <div class="flex flex-row mb-2 justify-between">
            
            <!-- TITLE -->
            <h1
                class="font-semibold text-xl text-gray-800 leading-tight mr-6"
            >{{ _.capitalize(props.mode)}}</h1>

            <!-- SUBMIT BUTTON -->
            <el-form-item>
                <el-button
                    @click="submit"
                    type="primary"
                >Save</el-button>
            </el-form-item>

            <!-- DELETE BUTTON -->
            <el-form-item
                v-if="props.mode === 'edit'"
            >
                <el-button
                    @click="destroy"
                    type="danger"
                >Delete</el-button>
            </el-form-item>

        </div>

        <!-- THE FORM -->
        <div>
            <el-form-item
                label="Auto book as private"
                prop="auto_book_as_private"
                :label-width="data.labelWidth"
            >
                <el-checkbox
                    v-model="data.customer.auto_book_as_private"
                    @change="handleChange"
                />
            </el-form-item>

            <el-form-item
                label="Dangerous goods"
                prop="dangerous_goods"
                :label-width="data.labelWidth"
            >
                <el-checkbox
                    v-model="data.customer.dangerous_goods"
                    @change="handleChange"
                />
            </el-form-item>

            <el-form-item
                label="Bussiness customer"
                prop="bussiness_customer"
                :label-width="data.labelWidth"
            >   
                <el-checkbox
                    v-model="data.customer.bussiness_customer"
                    @change="handleChange"
                />
            </el-form-item>

            <el-form-item
                label="Debt collection"
                prop="debt_collection"
                :label-width="data.labelWidth"
            >
                <el-checkbox
                    v-model="data.customer.debt_collection"
                    @change="handleChange"
                />
            </el-form-item>

            <el-form-item
                label="Direct debit"
                prop="direct_debit"
                :label-width="data.labelWidth"
            >   
                <el-checkbox
                    v-model="data.customer.direct_debit"
                    @change="handleChange"
                />
            </el-form-item>

            <el-form-item
                label="Manual collective invoicing"
                prop="manual_collective_invoicing"
                :label-width="data.labelWidth"
            >   
                <el-checkbox
                    v-model="data.customer.manual_collective_invoicing"
                    @change="handleChange"
                />
            </el-form-item>

            <el-form-item
                label="Private customer"
                prop="private_customer"
                :label-width="data.labelWidth"
            >
                <el-checkbox
                    v-model="data.customer.private_customer"
                    @change="handleChange"
                />
            </el-form-item>

            <el-form-item
                label="Invoice customer"
                prop="invoice_customer"
                :label-width="data.labelWidth"
            >
                <el-checkbox
                    v-model="data.customer.invoice_customer"
                    @change="handleChange"
                />
            </el-form-item>

            <el-form-item
                label="Poor payment morale"
                prop="poor_payment_morale"
                :label-width="data.labelWidth"
            >
                <el-checkbox
                    v-model="data.customer.poor_payment_morale"
                    @change="handleChange"
                />
            </el-form-item>

            <el-form-item
                label="Can login"
                prop="can_login"
                :label-width="data.labelWidth"
            >
                <el-checkbox
                    v-model="data.customer.can_login"
                    @change="handleChange"
                />
            </el-form-item>

            <!-- EL-SELECT FIELDS START HERE -->
            <!-- PROBLEM: the options window is not closing automatically, when an options is
            selected. Solution: use ref for el-select, then on change close the 
            options with the  @change=$refs.paymentMethodRef.blur()" trick. Source:
            https://github.com/ElemeFE/element/issues/11048 
            So, @change closes the popup, by triggering the @blur. The @blur is actully triggering
            the data update sync process with the parent component.
            -->
            <el-form-item
                label="Customer type"
                prop="customer_type"
                :label-width="data.labelWidth"
            >
                <div class="flex flex-col">
                    <el-select
                        ref="customerTypeRef"
                        v-model="data.customer.customer_type"
                        clearable
                        @change="$refs.customerTypeRef.blur()"
                        @blur="handleChange"
                    >
                        <el-option
                            v-for="(item, index) in props.selectOptions.customerTypes"
                            :key="index"
                            :label="item"
                            :value="item"
                        ></el-option>
                    </el-select>

                    <BackendValidationErrorDisplay :errorMessage="props.errors.customer_type"/>

                </div>
                

            </el-form-item>

            <!-- PROBLEM: the options window is not closing automatically, when an options is
            selected. Solution: use ref for el-select, then on change close the 
            options with the  @change=$refs.paymentMethodRef.blur()" trick. Source:
            https://github.com/ElemeFE/element/issues/11048 
            So, @change closes the popup, by triggering the @blur. The @blur is actully triggering
            the data update sync process with the parent component.
            -->
            <el-form-item
                label="Invoice dispatch"
                prop="invoice_dispatch"
                :label-width="data.labelWidth"
            >
                <div class="flex flex-col">

                    <el-select
                        ref="invoiceDispatchRef"
                        v-model="data.customer.invoice_dispatch"
                        clearable
                        @change="$refs.invoiceDispatchRef.blur()"
                        @blur="handleChange"
                    >
                        <el-option
                            v-for="(item, index) in props.selectOptions.invoiceDispatches"
                            :key="index"
                            :label="item"
                            :value="item"
                        ></el-option>

                    </el-select>
                    
                    <BackendValidationErrorDisplay :errorMessage="props.errors.invoice_dispatch"/>
                </div>

            </el-form-item>

            <!-- PROBLEM: the options window is not closing automatically, when an options is
            selected. Solution: use ref for el-select, then on change close the 
            options with the  @change=$refs.paymentMethodRef.blur()" trick. Source:
            https://github.com/ElemeFE/element/issues/11048 
            So, @change closes the popup, by triggering the @blur. The @blur is actully triggering
            the data update sync process with the parent component.
            -->
            <el-form-item
                label="Invoice shipping method"
                prop="invoice_shipping_method"
                :label-width="data.labelWidth"
            >
                <div class="flex flex-col">

                    <el-select
                        ref="invoiceShippingMethodRef"
                        v-model="data.customer.invoice_shipping_method"
                        clearable
                        @change="$refs.invoiceShippingMethodRef.blur()"
                        @blur="handleChange"
                    >
                        <el-option
                            v-for="(item, index) in props.selectOptions.invoiceShippingMethods"
                            :key="index"
                            :label="item"
                            :value="item"
                        ></el-option>
                    </el-select>

                    <BackendValidationErrorDisplay :errorMessage="props.errors.invoice_shipping_method"/>
                </div>
            </el-form-item>

            <!-- ****************************************************************************** -->
            <!-- PROBLEM: the options window is not closing automatically, when an options is
            selected. Solution: use ref for el-select, then on change close the 
            options with the  @change=$refs.paymentMethodRef.blur()" trick. Source:
            https://github.com/ElemeFE/element/issues/11048 
            So, @change closes the popup, by triggering the @blur. The @blur is actully triggering
            the data update sync process with the parent component.
            -->
            <!-- 1: OPTIONS THAT CAN BE OFFERED TO THIS CUSTOMER -->
            <el-form-item
                label="Payment method options to offer"
                prop="payment_method_options_to_offer"
                :label-width="data.labelWidth"
            >
                <div class="flex flex-col">

                    <!-- MULTIPLE -->
                    <!-- It offers all existing payment_options from TmsCustomer::PAYMENT_METHODS -->
                    <!-- Selected offers go to the json column -->
                    <!-- @change="$refs.paymentMethodRef.blur()" -->
                    <el-select
                        ref="paymentMethodRef"
                        v-model="data.customer.payment_method_options_to_offer"
                        clearable
                        multiple
                        @change="handleChange"
                        @blur="handleChange"
                    >
                        <el-option
                            v-for="(item, index) in props.selectOptions.paymentMethods"
                            :key="index"
                            :label="item"
                            :value="item"
                        ></el-option>
                    </el-select>

                    <BackendValidationErrorDisplay :errorMessage="props.errors.payment_method_options_to_offer"/>
                </div>
            </el-form-item>

            <!-- PROBLEM: the options window is not closing automatically, when an options is
            selected. Solution: use ref for el-select, then on change close the 
            options with the  @change=$refs.paymentMethodRef.blur()" trick. Source:
            https://github.com/ElemeFE/element/issues/11048 
            So, @change closes the popup, by triggering the @blur. The @blur is actully triggering
            the data update sync process with the parent component.
            -->
            <!-- 2: SELECTED PAYMENT OPTION -->
            <el-form-item
                label="Payment method"
                prop="payment_method"
                :label-width="data.labelWidth"
            >
                <div class="flex flex-col">

                    <el-select
                        ref="paymentMethodRef"
                        v-model="data.customer.payment_method"
                        clearable
                        @change="$refs.paymentMethodRef.blur()"
                        @blur="handleChange"
                    >
                        <el-option
                            v-for="(item, index) in data.customer.payment_method_options_to_offer"
                            :key="index"
                            :label="item"
                            :value="item"
                        ></el-option>
                    </el-select>

                    <BackendValidationErrorDisplay :errorMessage="props.errors.payment_method"/>
                </div>
            </el-form-item>

            <!-- **************************************************************************** -->
            <el-form-item
                label="Email for invoice"
                prop="email_for_invoice"
                width="100px"
                :label-width="data.labelWidth"
            >
                <div class="flex flex-col">

                    <el-input
                        v-model="data.customer.email_for_invoice"
                        placeholder="Email for invoice"
                        type="text"
                        show-word-limit
                        :maxlength="255"
                        clearable
                        @input="handleChange()"
                        @clear="handleChange()"
                        @change="handleChange()"
                    />

                    <BackendValidationErrorDisplay :errorMessage="props.errors.email_for_invoice"/>

                </div>
            </el-form-item>

            <el-form-item
                label="Email for label"
                prop="email_for_label"
                width="100px"
                :label-width="data.labelWidth"
            >
                <div class="flex flex-col">

                    <el-input
                        v-model="data.customer.email_for_label"
                        placeholder="Email for label"
                        type="text"
                        show-word-limit
                        :maxlength="255"
                        clearable
                        @input="handleChange()"
                        @clear="handleChange()"
                        @change="handleChange()"
                    />

                    <BackendValidationErrorDisplay :errorMessage="props.errors.email_for_label"/>

                </div>
            </el-form-item>

            <el-form-item
                label="Email for POD"
                prop="email_for_pod"
                width="100px"
                :label-width="data.labelWidth"
            >
                <div class="flex flex-col">

                    <el-input
                        v-model="data.customer.email_for_pod"
                        placeholder="Email for POD"
                        type="text"
                        show-word-limit
                        :maxlength="255"
                        clearable
                        @input="handleChange()"
                        @clear="handleChange()"
                        @change="handleChange()"
                    />

                    <BackendValidationErrorDisplay :errorMessage="props.errors.email_for_pod"/>

                </div>
            </el-form-item>

            <el-form-item
                label="Customer reference"
                prop="customer_reference"
                width="100px"
                :label-width="data.labelWidth"
            >
                <div class="flex flex-col">

                    <el-input
                        v-model="data.customer.customer_reference"
                        placeholder="Customer reference"
                        type="text"
                        show-word-limit
                        :maxlength="255"
                        clearable
                        @input="handleChange()"
                        @clear="handleChange()"
                        @change="handleChange()"
                    />

                    <BackendValidationErrorDisplay :errorMessage="props.errors.customer_reference"/>

                </div>
            </el-form-item>
        </div>

    </el-form>
</template>

<script setup>
import { reactive, computed } from 'vue';
import _ from 'lodash';
import BackendValidationErrorDisplay from '@/Shared/Validation/BackendValidationErrorDisplay.vue';

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

    mode: {
        type: String,
        required: true
    },
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

const submit = () => {
    emit('submit');
}

const destroy = () => {
    emit('destroy');
}

</script>

<style scoped>
</style>