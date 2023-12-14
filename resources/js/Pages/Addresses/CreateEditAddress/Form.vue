<template>
    <el-form
        ref="elFormRef"
        :model="data.addressData"
        label-position="left"
        :rules="rules"
        label-width="150px"
    >

        <!-- HEADER -->
        <div class="flex flex-row mb-2 justify-between">
            
            <!-- ADDRESS HEADER WITH BASIC ADDRESS DATA -->
            <Header
                :record="data.addressData"
                :mode="props.mode"
                :headerText="headerText"
            />
            
            <!-- SUBMIT BUTTON -->
            <el-form-item>
                <el-button
                    @click="submit(elFormRef)"
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

        <!-- THE FORM -->
        <div>

            <el-form-item
                label="First name"
                prop="first_name"
                width="100px"
            >
                <el-input
                    v-model="data.addressData.first_name"
                    placeholder="First name"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.first_name"/>

            </el-form-item>

            <el-form-item
                label="Last name"
                prop="last_name"
                width="100px"
            >
                <el-input
                    v-model="data.addressData.last_name"
                    placeholder="Last name"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.last_name"/>

            </el-form-item>

            <el-form-item
                label="Address type"
                prop="address_type"
            >
                <el-select
                    v-model="data.addressData.address_type"
                    clearable
                    @change="update()"
                >
                    <el-option
                        v-for="(item, index) in props.addressTypes"
                        :key="index"
                        :label="item"
                        :value="item"
                    ></el-option>
                </el-select>
                    
                <BackendValidationErrorDisplay :errorMessage="props.errors.address_type"/>

            </el-form-item>

            <el-form-item
                label="Street"
                prop="street"
                width="100px"
            >
                <el-input
                    v-model="data.addressData.street"
                    placeholder="Street"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.street"/>

            </el-form-item>

            <el-form-item
                label="House number"
                prop="house_number"
                width="100px"
            >
                <el-input
                    v-model="data.addressData.house_number"
                    placeholder="House number"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.house_number"/>

            </el-form-item>

            <el-form-item
                label="Zip code"
                prop="zip_code"
                width="100px"
            >
                <el-input
                    v-model="data.addressData.zip_code"
                    placeholder="Zip code"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.zip_code"/>

            </el-form-item>

            <el-form-item
                label="City"
                prop="city"
                width="100px"
            >
                <el-input
                    v-model="data.addressData.city"
                    placeholder="City"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.city"/>

            </el-form-item>

            <el-form-item
                label="Country"
                prop="country_code"
                width="100px"
            >
                <el-input
                    v-model="data.addressData.country_code"
                    placeholder="Country"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.country_code"/>

            </el-form-item>

            <el-form-item
                label="State"
                prop="state"
                width="100px"
            >
                <el-input
                    v-model="data.addressData.state"
                    placeholder="State"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.state"/>

            </el-form-item>


            <el-form-item
                label="Comment"
                prop="comment"
                width="100px"
            >
                <el-input
                    v-model="data.addressData.comment"
                    placeholder="Comment"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"                    
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.comment"/>

            </el-form-item>

            <!-- CUSTOMER -->
            <el-form-item
                label="Customer"
                prop="customer_id"
                width="100px"
            >
                <!-- EL-SELECT -->
                <el-select
                    v-model="data.addressData.customer_id"
                    clearable
                    filterable
                    @change="update()"
                >
                    <el-option
                        v-for="(item, index) in props.customers"
                        :key="index"
                        :label="item.name"
                        :value="item.id"
                    ></el-option>
                </el-select>

                <BackendValidationErrorDisplay :errorMessage="props.errors.customer_id"/>

            </el-form-item>

            <!-- FORWARDER -->
            <el-form-item
                label="Forwarder"
                prop="forwarder_id"
                width="100px"
            >
                <!-- EL-SELECT -->
                <el-select
                    v-model="data.addressData.forwarder_id"
                    clearable
                    filterable
                    @change="update()"
                >
                    <el-option
                        v-for="(item, index) in props.forwarders"
                        :key="index"
                        :label="item.name"
                        :value="item.id"
                    ></el-option>
                </el-select>

                <BackendValidationErrorDisplay :errorMessage="props.errors.forwarder_id"/>

            </el-form-item>
        </div>

    </el-form>
</template>

<script setup>
import { reactive, ref, onBeforeMount, watch, computed } from 'vue';
import Header from '@/Shared/Crud/Header.vue';
import _ from 'lodash';
import BackendValidationErrorDisplay from '@/Shared/Validation/BackendValidationErrorDisplay.vue';
import addressValidationRules from './addressValidationRules.js';

const props = defineProps({

    /**
     * The address object.
     */
    address: {
        type: Object,
    },

    /**
     * The validation errors object. Comes from the backend.
     */
    errors: {
        type: Object,
        required: true
    },

    /**
     * mode is either 'create' or 'edit'. This is decided in the controller. This component will
     * behave differently depending on which mode is it.
     */
    mode: {
        type: String,
        required: true
    },

    /**
     * The address types. Needed for the address type select.
     */
    addressTypes: {
        type: Array,
        required: true
    },

    /**
     * The customers. Needed for the customer select.
     */
    customers: {
        type: Array,
        required: true
    },
    
    /**
     * The forwarders. Needed for the forwarder select.
     */
    forwarders: {
        type: Array,
        required: true
    },
});

/**
 * The data object that contains the address data.
 */
const data = reactive({
    addressData: props.address || {},
});

/**
 * This form has a header. This header's text is dynamic, and it is created here.
 */
const headerText = computed(() => {
    //_.get() returns undefined if the path doesn't exist. Which is faulty.
    if (props.mode === 'edit' && _.get(props.address, 'id')) {
        return _.capitalize(props.mode) + ` address id: ${props.address.id}`;
    } else {
        return _.capitalize(props.mode) + ' new address';
    }
});

const emit = defineEmits(['update:address', 'submit', 'destroy']);

/**
 * Only updates the parent's address object. No triggering of submit or edit. No need for validation.
 */
const update = () => {
    emit('update:address', data.addressData);
}

//It is called destroy, because delete is a reserved word in JS
const destroy = () => {
    emit('destroy');
}


//*************************** FRONTEND FORM VALIDATION ***************************//
/**
 * This contains the whole el-form. Needed for the validation.
 */
 const elFormRef = ref();

/**
 * Starts the submitting proces. First step: frontend validation. It takes the el-form as an
 * argument. This is possible, because the el-form is captured in const elFormRef = ref(); The
 * el-form has the logic for FE validation. 
 */
 const submit = (elFormRef) => {
    validate(elFormRef);
}

/**
 * Does the frontend validation, and if it is OK, then emits the signal for creating/editing. That
 * signal is received by the parent CreateEditAddress.vue component. If it is not ok, then:
 * 1. there will be red error messages under the relevant fields
 * 2. no emit will happen
 */
 const validate = async (elFormRef) => {
    console.log('submit() called, FE validation starts')
    if (!elFormRef) return;

    await elFormRef.validate((valid, fields) => {
        
        if (valid) {
            //if validation is OK, then submit
            console.log('FE validation OK, submit!', fields)
            emit('submit');
        
        } else {
            //if validation is not OK, then log the problematic validation fields
            console.log('FE validation not OK, error submit!', fields)
        }
    })
}

/**
 * The FE validation rules for the form. We import this from a separate file, because it is too
 * long to be here.
 */
const rules = reactive(
    addressValidationRules//this is = to addressValidationRules: addressValidationRules
);




</script>