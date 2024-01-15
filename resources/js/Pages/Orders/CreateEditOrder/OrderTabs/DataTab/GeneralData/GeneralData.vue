<template>
    <div>

        <div class="flex justify-between mt-6">

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
                        v-model="data.order.type_of_transport"
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
                        v-model="data.order.customer_reference"
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
                        v-model="data.order.status"
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
                        v-model="data.order.order_date"
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
                        v-model="data.order.origin"
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
                :prop="[subOrderType].payment_method"
            >   
                <div class="flex flex-col">

                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Payment method</span>
                    
                    <el-select
                        v-model="data.order[subOrderType].payment_method"
                        placeholder="Payment method"
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
                
                <!-- :errorMessage="props.errors[subOrderType].payment_method" -->
                <!-- v-if="subOrderType === 'pamyra_order' || subOrderType === 'native_order'" -->
                <!-- :errorMessage="props.errors['native_order'] || ['pamyra_order'].payment_method" -->
                <!-- :errorMessage="props.errors[subOrderType]?.payment_method" -->
                <!-- //TODO LOSI itt kellene segitseg -->
                <!-- pamyra_order.payment_method:"The pamyra_order.payment_method field is required." -->
                <!-- errorsMessage:undefined -->
                <BackendValidationErrorDisplay
                    
                    :errorsMessage="data.errorsFromWatcher[subOrderType]?.payment_method"
                />

            </el-form-item>

            <!-- DATE OF SALE -->
            <el-form-item
                :prop="[subOrderType].date_of_sale"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Date of sale</span>

                    <el-date-picker
                        v-model="data.order[subOrderType].date_of_sale"
                        type="date"
                        format="DD-MM-YYYY"
                        value-format="YYYY-MM-DD"
                        @change="updateParent()"
                        editable
                        clearable
                        style="width: 100%"
                    ></el-date-picker>

                </div>
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.date_of_sale"
                />

            </el-form-item>

            <!-- DATE OF CANCELLATION -->
            <el-form-item
                :prop="[subOrderType].date_of_cancellation"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Date of cancellation</span>

                    <el-date-picker
                        v-model="data.order[subOrderType].date_of_cancellation"
                        type="date"
                        format="DD-MM-YYYY"
                        value-format="YYYY-MM-DD"
                        @change="updateParent()"
                        editable
                        clearable
                        style="width: 100%"
                    ></el-date-picker>

                </div>
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.date_of_cancellation"
                />

            </el-form-item>

            <!-- DISTANCE -->
            <el-form-item
                :prop="[subOrderType].distance_km"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Distance (km)</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].distance_km"
                        placeholder="Distance (km)"
                        clearable
                        @input="updateParent"
                    />

                </div>
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.distance_km"
                />

            </el-form-item>

            <!-- DURATION -->
            <el-form-item
                :prop="[subOrderType].duration_minutes"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Duration (min)</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="props.order[subOrderType].duration_minutes"
                        placeholder="Duration (min)"
                        clearable
                        @input="updateParent"
                    />

                </div>
                
                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.duration_minutes"
                />

            </el-form-item>

            <el-form-item
                prop="month_and_year"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Month and year</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order.month_and_year"
                        placeholder="Month and year"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.month_and_year"
                />

            </el-form-item>

            <el-form-item
                :prop="[subOrderType].calculation_model_name"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Calculation model name</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].calculation_model_name"
                        placeholder="Calculation model name"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.calculation_model_name"
                />

            </el-form-item>

            <!-- **********************THE FOLLOWING ITEMS ARE UNTESTED AND UNFINISHED. Input fields probalby work, but dateTime stuff should be DatePicker intstead of input fields.******************** -->
            <el-form-item
                :prop="[subOrderType].pickup_date_from"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Pickup date from</span>
                    
                    <!-- INPUT -->

                    <el-date-picker
                        v-model="data.order[subOrderType].pickup_date_from"
                        type="datetime"
                        format="DD-MM-YYYY HH:mm"
                        value-format="YYYY-MM-DD HH:mm:ss"
                        @change="updateParent()"
                        editable
                        clearable
                        style="width: 100%"
                    ></el-date-picker>

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.pickup_date_from"
                />

            </el-form-item>

            <el-form-item
                :prop="[subOrderType].pickup_date_to"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Pickup date to</span>

                    <el-date-picker
                        v-model="data.order[subOrderType].pickup_date_to"
                        type="datetime"
                        format="DD-MM-YYYY HH:mm"
                        value-format="YYYY-MM-DD HH:mm:ss"
                        @change="updateParent()"
                        editable
                        clearable
                        style="width: 100%"
                    ></el-date-picker>

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.pickup_date_to"
                />

            </el-form-item>

            <el-form-item
                :prop="[subOrderType].delivery_date_from"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Delivery date from</span>

                    <el-date-picker
                        v-model="data.order[subOrderType].delivery_date_from"
                        type="datetime"
                        format="DD-MM-YYYY HH:mm"
                        value-format="YYYY-MM-DD HH:mm:ss"
                        @change="updateParent()"
                        editable
                        clearable
                        style="width: 100%"
                    ></el-date-picker>

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.delivery_date_from"
                />

            </el-form-item>

            <el-form-item
                :prop="[subOrderType].delivery_date_to"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Delivery date to</span>

                    <el-date-picker
                        v-model="data.order[subOrderType].delivery_date_to"
                        type="datetime"
                        format="DD-MM-YYYY HH:mm"
                        value-format="YYYY-MM-DD HH:mm:ss"
                        @change="updateParent()"
                        editable
                        clearable
                        style="width: 100%"
                    ></el-date-picker>

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.delivery_date_to"
                />

            </el-form-item>

            <el-form-item
                :prop="[subOrderType].description_of_transport"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Description of transport</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].description_of_transport"
                        placeholder="Description of transport"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.description_of_transport"
                />

            </el-form-item>

            <el-form-item
                :prop="[subOrderType].particularities"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Particularities</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order[subOrderType].particularities"
                        placeholder="Particularities"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.particularities"
                />

            </el-form-item>
        </div>
    </div>
</template>

<script setup>
import { reactive, computed, watch, onMounted, onBeforeMount, ref, onUpdated, nextTick } from 'vue';
import BackendValidationErrorDisplay from '@/Shared/Validation/BackendValidationErrorDisplay.vue';
import { useDateFormatter } from '@/Use/useDateFormatter';
import Title from '@/Shared/Title.vue';

const props = defineProps({
    order: {
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
    order: props.order,
    showLabel: true,
    showGeneralData: true,
    errorsFromWatcher: props.errors,
});

watch(
    () => props.errors, 
    (newValue, oldValue) => {
        console.log('oldValue:', oldValue)
        console.log('newValue:', newValue)
        data.errorsFromWatcher = newValue;
    },
    { deep: true }
);


/**
 * The order can have either a pamyra_order or a native_order property. Either, or. We have a lot
 * of data, that we must render from this property. Since we don't know which property is set in
 * the order, we must display this key dynamically. This dynamic key rendering is done in this
 * computed property.
 * Now, in order to use dynamic keyes in an object, we must use the [] notation. Not dot notation.
 * This happens in the hmtl part of this component.
 */
const subOrderType = computed(
    () => {
        if (props.order.pamyra_order !== null) {
            return 'pamyra_order';
        }
        if (props.order.native_order !== null) {
            return 'native_order';
            
        }
    }
);

const emit = defineEmits(['update:order']);

/**
 * This function is called when the user types in the el-input. It updates the parent component
 * order.customer_reference. It does not triggers anything!
 */
const updateParent = () => {
    emit('update:order', props.order);
}

</script>