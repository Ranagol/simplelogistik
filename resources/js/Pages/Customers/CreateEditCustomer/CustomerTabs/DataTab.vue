<template>

    <!-- <pre>{{ JSON.stringify(data.customer, null, 2) }}</pre> -->

    <!-- :rules="rules" -->
    <el-form
        ref="ruleFormRef"
        :model="data.customer"
        label-position="left"
        label-width="150px"
    >
        <!-- HEADER -->
        <div class="flex mb-2 justify-between">
            
            <!-- TITLE -->
            <h1
                class="font-semibold text-xl text-gray-800 leading-tight mr-6"
            >{{ _.capitalize(props.mode)}}</h1>

            <div class="flex justify-end">

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
        </div>

        <!-- INPUT FIELDS -->
        <div>
            <el-form-item
                label="Company name"
                prop="company_name"
                width="100px"
            >
                <el-input
                    v-model="data.customer.company_name"
                    placeholder="Company name"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.company_name"/>

            </el-form-item>

            <el-form-item
                label="Internal ID"
                prop="internal_id"
            >
                <el-input
                    v-model="data.customer.internal_id"
                    placeholder="Customer number"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.internal_id"/>

            </el-form-item>

            <el-form-item
                label="First name"
                prop="first_name"
            >
                <el-input
                    v-model="data.customer.first_name"
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
            >
                <el-input
                    v-model="data.customer.last_name"
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
                label="Phone"
                prop="phone"
            >
                <el-input
                    v-model="data.customer.phone"
                    placeholder="Phone"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.phone"/>

            </el-form-item>

            <el-form-item
                label="Email"
                prop="email"
            >
                <el-input
                    v-model="data.customer.email"
                    placeholder="Email"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.email"/>

            </el-form-item>

            <el-form-item
                label="Tax number"
                prop="tax_number"
            >
                <el-input
                    v-model="data.customer.tax_number"
                    placeholder="Tax number"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.tax_number"/>

            </el-form-item>

            <el-form-item
                label="Rating"
                prop="rating"
            >
                <el-input
                    v-model="data.customer.rating"
                    placeholder="Rating"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.rating"/>
                
            </el-form-item>

            <el-form-item
                label="Payment time (days)"
                prop="payment_time"
            >
                <el-input
                    v-model="data.customer.payment_time"
                    placeholder="Payment time (days)"
                    clearable
                    show-word-limit
                    :maxlength="255"
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

                <BackendValidationErrorDisplay :errorMessage="props.errors.payment_time"/>
                
            </el-form-item>

            <el-form-item
                prop="forwarder_name"
                label="Forwarder"
            >

                <el-select
                    v-model="data.customer.forwarder"
                    value-key="id"
                    clearable
                    filterable
                    style="width: 100%"
                    @change="update()"
                >
                    <el-option
                        v-for="(item, index) in props.forwarders"
                        :key="index"
                        :label="item.name"
                        :value="item"
                    ></el-option>

                </el-select>

                <BackendValidationErrorDisplay :errorMessage="props.errors.forwarder"/>

            </el-form-item>
            
        </div>
    </el-form>
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import _ from 'lodash';
import BackendValidationErrorDisplay from '@/Shared/Validation/BackendValidationErrorDisplay.vue';


let props = defineProps({

    /**
     * The customer object.
     */
    modelValue: {
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
    customer: props.modelValue
});

/**
 * This does the customer data synchronization with the parent CreateEditBase component. With
 * v-model magic. This is not sending a signal for saving the customer! Just the data.customer.
 */
const emit = defineEmits(['update:modelValue', 'submit', 'destroy']);

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

<style scoped>
</style>