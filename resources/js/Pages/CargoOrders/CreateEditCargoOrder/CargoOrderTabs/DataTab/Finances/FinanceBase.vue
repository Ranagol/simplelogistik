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
                prop="p_transport_price_net"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Transport price net</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_transport_price_net"
                        placeholder="Transport price net"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_transport_price_net"
                />

            </el-form-item>

            <el-form-item
                prop="p_transport_price_vat"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Transport price vat</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_transport_price_vat"
                        placeholder="Transport price vat"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_transport_price_vat"
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
                        v-model="data.cargoOrder.purchase_price"
                        placeholder="Purchase price"
                        clearable
                        @input="updateParent"
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
                        v-model="data.cargoOrder.provision"
                        placeholder="Provision"
                        clearable
                        @input="updateParent"
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
                        v-model="data.cargoOrder.currency"
                        placeholder="Currency"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.currency"
                />

            </el-form-item>

            <el-form-item
                prop="p_calculated_transport_price"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Calculated transport price</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_calculated_transport_price"
                        placeholder="Calculated transport price"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_calculated_transport_price"
                />

            </el-form-item>

            <el-form-item
                prop="p_transport_price_gross"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Transport price gross</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_transport_price_gross"
                        placeholder="Transport price gross"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_transport_price_gross"
                />

            </el-form-item>

            <el-form-item
                prop="p_customized_price_change"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Customized price change</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_customized_price_change"
                        placeholder="Customized price change"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_customized_price_change"
                />

            </el-form-item>

            <el-form-item
                prop="p_customized_price_mode"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Customized price mode</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_customized_price_mode"
                        placeholder="Customized price mode"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_customized_price_mode"
                />

            </el-form-item>

            <el-form-item
                prop="p_discount"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Discount</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_discount"
                        placeholder="Discount"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_discount"
                />

            </el-form-item>

            <el-form-item
                prop="p_price_gross"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Price gross</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_price_gross"
                        placeholder="Price gross"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_price_gross"
                />

            </el-form-item>

            <el-form-item
                prop="p_price_vat"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Price vat</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_price_vat"
                        placeholder="Price vat"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_price_vat"
                />

            </el-form-item>

            <el-form-item
                prop="p_price_net"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Price net</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_price_net"
                        placeholder="Price net"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_price_net"
                />

            </el-form-item>

            <el-form-item
                prop="p_price_fuel_surcharge"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Price fuel surcharge</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_price_fuel_surcharge"
                        placeholder="Price fuel surcharge"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_price_fuel_surcharge"
                />

            </el-form-item>

            <el-form-item
                prop="p_vat_rate"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Vat rate</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_vat_rate"
                        placeholder="Vat rate"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_vat_rate"
                />

            </el-form-item>

            <el-form-item
                prop="p_value_insured"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Value insured</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_value_insured"
                        placeholder="Value insured"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_value_insured"
                />

            </el-form-item>

            <el-form-item
                prop="p_value_of_goods"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Value of goods</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_value_of_goods"
                        placeholder="Value of goods"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_value_of_goods"
                />

            </el-form-item>
            
        </div>
    </div>

</template>

<script setup>
import { defineProps, reactive } from 'vue';
import Title from '@/Shared/Title.vue';
import BackendValidationErrorDisplay from '@/Shared/Validation/BackendValidationErrorDisplay.vue';

const props = defineProps({
    cargoOrder: {
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

const data = reactive({
    cargoOrder: props.cargoOrder,
    showFinances: false,
    showLabel: true,
});

</script>