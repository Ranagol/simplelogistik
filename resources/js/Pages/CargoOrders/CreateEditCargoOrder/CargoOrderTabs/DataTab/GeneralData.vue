<template>
    <div>

        <div class="flex justify-between">

            <!-- TITLE -->
            <Title 
                title="General data" 
            />

            <el-switch 
                v-model="data.showGeneralData"
            />

        </div>

        <!-- INPUT FIELDS START HERE.  -->
        <div 
            v-if="data.showGeneralData" 
            class="grid grid-cols-5 gap-4"
        >

            <!-- TYPE OF TRANSPORT -->
            <el-form-item
                prop="type_of_transport"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Type of transport</span>
                    
                    <el-select
                        v-model="data.cargoOrder.type_of_transport"
                        placeholder="Type of transport"
                        clearable
                        filterable
                        style="width: 100%"
                        @change="updateParent"
                    >
                        <el-option
                            v-for="(item, index) in props.selectOptions.typesOfTransport"
                            :key="index"
                            :label="item"
                            :value="item"
                        ></el-option>
                    </el-select>

                </div>
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.type_of_transport"
                />

            </el-form-item>

            <!-- YOUR REFERENCE -->
            <el-form-item
                prop="customer_reference"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Customer reference</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.customer_reference"
                        placeholder="Customer reference"
                        clearable
                        @input="updateParent"
                    />

                </div>
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.customer_reference"
                />

            </el-form-item>

            <!-- STATUS -->
            <el-form-item
                prop="status"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Status</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.status"
                        placeholder="Status - IN PROGRESS"
                        clearable
                        @input="updateParent"
                    />

                </div>
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.status"
                />

            </el-form-item>

            <!-- ORDER DATE -->
            <el-form-item
                prop="created_at"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Order date</span>

                    <el-date-picker
                        v-model="data.cargoOrder.order_date"
                        type="date"
                        format="YYYY-MM-DD"
                        value-format="YYYY-MM-DD"
                        @change="updateParent()"
                        editable
                        clearable
                        style="width: 100%"
                    ></el-date-picker>

                </div>
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.order_date"
                />

            </el-form-item>

            <!-- ORIGIN -->
            <el-form-item
                prop="origin"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Origin</span>
                    
                    <!-- INPUT -->
                    <el-select
                        v-model="data.cargoOrder.origin"
                        placeholder="Type of transport"
                        clearable
                        filterable
                        @change="updateParent"
                    >
                        <el-option
                            v-for="(item, index) in props.selectOptions.origins"
                            :key="index"
                            :label="item"
                            :value="item"
                        ></el-option>
                    </el-select>

                </div>
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.origin"
                />

            </el-form-item>

            <!-- PAYMENT METHOD -->
            <el-form-item
                prop="p_payment_method"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Payment method</span>
                    
                    <!-- INPUT -->
                    <el-select
                        v-model="data.cargoOrder.p_payment_method"
                        placeholder="Type of transport"
                        clearable
                        filterable
                        @change="updateParent"
                    >
                        <el-option
                            v-for="(item, index) in props.selectOptions.paymentMethods"
                            :key="index"
                            :label="item"
                            :value="item"
                        ></el-option>
                    </el-select>

                </div>
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_payment_method"
                />

            </el-form-item>

            <!-- DATE OF SALE -->
            <el-form-item
                prop="p_date_of_sale"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Date of sale</span>

                    <el-date-picker
                        v-model="data.cargoOrder.p_date_of_sale"
                        type="date"
                        format="YYYY-MM-DD"
                        value-format="YYYY-MM-DD"
                        @change="updateParent()"
                        editable
                        clearable
                        style="width: 100%"
                    ></el-date-picker>

                </div>
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_date_of_sale"
                />

            </el-form-item>

            <!-- DATE OF CANCELLATION -->
            <el-form-item
                prop="p_date_of_cancellation"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Date of cancellation</span>

                    <el-date-picker
                        v-model="data.cargoOrder.p_date_of_cancellation"
                        type="date"
                        format="YYYY-MM-DD"
                        value-format="YYYY-MM-DD"
                        @change="updateParent()"
                        editable
                        clearable
                        style="width: 100%"
                    ></el-date-picker>

                </div>
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_date_of_cancellation"
                />

            </el-form-item>

            <!-- DISTANCE -->
            <el-form-item
                prop="p_distance_km"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Distance (km)</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="props.cargoOrder.p_distance_km"
                        placeholder="Distance (km)"
                        clearable
                        @input="updateParent"
                    />

                </div>
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_distance_km"
                />

            </el-form-item>

            <!-- DURATION -->
            <el-form-item
                prop="p_duration_minutes"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Duration (min)</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="props.cargoOrder.p_duration_minutes"
                        placeholder="Duration (min)"
                        clearable
                        @input="updateParent"
                    />

                </div>
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_duration_minutes"
                />

            </el-form-item>
        </div>
    </div>
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import BackendValidationErrorDisplay from '@/Shared/Validation/BackendValidationErrorDisplay.vue';
import { useDateFormatter } from '@/Use/useDateFormatter';
import Title from '@/Shared/Title.vue';

const props = defineProps({
    cargoOrder: {
        type: Object,
        required: true
    },
    errors: {
        type: Object,
        required: true
    },
    mode: {
        type: String,
        required: true
    },
    selectOptions: Object,
});

let data = reactive({
    cargoOrder: props.cargoOrder,
    showLabel: true,
    showToolTip: true,
    showGeneralData: true,
});

const emit = defineEmits(['update:cargoOrder']);

/**
 * This function is called when the user types in the el-input. It updates the parent component
 * cargoOrder.customer_reference. It does not triggers anything!
 */
const updateParent = () => {
    emit('update:cargoOrder', props.cargoOrder);
}




</script>