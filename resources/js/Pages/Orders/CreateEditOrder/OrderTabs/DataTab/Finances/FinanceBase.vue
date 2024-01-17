<template>
    <div>
        <div class="flex justify-between mt-6">

            <!-- TITLE -->
            <Title 
                title="Finances" 
            />

            <el-switch 
                v-model="data.showFinances"
            />

        </div>

        <!-- INPUT FIELDS START HERE.  -->
        <div 
            v-if="data.showFinances"
            class="grid grid-cols-5 gap-4 mt-4"
        >

            <el-form-item
                prop="transport_price_net"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Transport price net</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].transport_price_net"
                        placeholder="Transport price net"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors[subOrderType + '.transport_price_net']"
                />

            </el-form-item>

            <el-form-item
                prop="transport_price_vat"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Transport price vat</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].transport_price_vat"
                        placeholder="Transport price vat"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors[subOrderType + '.transport_price_vat']"
                />

            </el-form-item>

            <el-form-item
                prop="purchase_price"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Purchase price</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order.purchase_price"
                        placeholder="Purchase price"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.purchase_price"
                />

            </el-form-item>

            <el-form-item
                prop="provision"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Provision</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order.provision"
                        placeholder="Provision"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.provision"
                />

            </el-form-item>

            <el-form-item
                prop="currency"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Currency</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order.currency"
                        placeholder="Currency"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.currency"
                />

            </el-form-item>

            <el-form-item
                prop="calculated_transport_price"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Calculated transport price</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].calculated_transport_price"
                        placeholder="Calculated transport price"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors[subOrderType + '.calculated_transport_price']"

                />

            </el-form-item>

            <el-form-item
                prop="transport_price_gross"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Transport price gross</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].transport_price_gross"
                        placeholder="Transport price gross"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors[subOrderType + '.transport_price_gross']"

                />

            </el-form-item>

            <el-form-item
                prop="customized_price_change"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Customized price change</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].customized_price_change"
                        placeholder="Customized price change"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors[subOrderType + '.customized_price_change']"

                />

            </el-form-item>

            <el-form-item
                prop="customized_price_mode"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Customized price mode</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].customized_price_mode"
                        placeholder="Customized price mode"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors[subOrderType + '.customized_price_mode']"
                />

            </el-form-item>

            <el-form-item
                prop="discount"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Discount</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].discount"
                        placeholder="Discount"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors[subOrderType + '.discount']"
                />

            </el-form-item>

            <el-form-item
                prop="price_gross"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Price gross</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].price_gross"
                        placeholder="Price gross"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors[subOrderType + '.price_gross']"
                />

            </el-form-item>

            <el-form-item
                prop="price_vat"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Price vat</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].price_vat"
                        placeholder="Price vat"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors[subOrderType + '.price_vat']"
                />

            </el-form-item>

            <el-form-item
                prop="price_net"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Price net</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].price_net"
                        placeholder="Price net"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors[subOrderType + '.price_net']"
                />

            </el-form-item>

            <el-form-item
                prop="price_fuel_surcharge"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Price fuel surcharge</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].price_fuel_surcharge"
                        placeholder="Price fuel surcharge"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors[subOrderType + '.price_fuel_surcharge']"
                />

            </el-form-item>

            <el-form-item
                prop="vat_rate"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Vat rate</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].vat_rate"
                        placeholder="Vat rate"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors[subOrderType + '.vat_rate']"
                />

            </el-form-item>

            <el-form-item
                prop="value_insured"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Value insured</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].value_insured"
                        placeholder="Value insured"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors[subOrderType + '.value_insured']"
                />

            </el-form-item>

            <el-form-item
                prop="value_of_goods"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Value of goods</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].value_of_goods"
                        placeholder="Value of goods"
                        clearable
                        @input="update"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors[subOrderType + '.value_of_goods']"
                />

            </el-form-item>
            
        </div>
    </div>

</template>

<script setup>
import { defineProps, reactive, computed } from 'vue';
import Title from '@/Shared/Title.vue';
import BackendValidationErrorDisplay from '@/Shared/Validation/BackendValidationErrorDisplay.vue';
import useSubOrderType from '@/Use/useSubOrderType';

const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
    mode: {
        type: String,
        required: true,
    },
});

/**
 * See the useSubOrderType composable for more information.
 * This must be positioned after the props!
 */
const { subOrderType } = useSubOrderType(props.order);

const data = reactive({
    order: props.order,
    showFinances: true,
    showLabel: true,
});

const update = () => {
    // props.$emit('update:order', data.order);
};

</script>