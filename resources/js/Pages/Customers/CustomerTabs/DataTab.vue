<template>
    <slot name="buttonSubmitTab"></slot>

    <!-- {{ data.customer }} -->
    <!-- <pre>{{ JSON.stringify(data.customer, null, 2) }}</pre> -->

    <el-form
        ref="ruleFormRef"
        :model="data.customer"
        label-position="left"
        :rules="rules"
        label-width="150px"
    >
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

            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.company_name"
                v-text="props.errors.company_name"
                class="text-red-500 text-xs mt-1"
            ></div>
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

            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.name"
                v-text="props.errors.name"
                class="text-red-500 text-xs mt-1"
            ></div>
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

            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.name"
                v-text="props.errors.name"
                class="text-red-500 text-xs mt-1"
            ></div>
        </el-form-item>

        <!-- ***************************** -->

        <!-- This here is not editable, it is only for displaying. Now, this street may or may not
            exist. So this column we handle with computed. Since this is not validated, also there
            is no props in el-form-item. 
         -->
        <el-form-item
            label="Street"
        >
            <el-input
                :model-value="street"
                disabled
                placeholder="Street"
                type="text"
            />

        </el-form-item>

        <!-- This here is not editable, it is only for displaying. Now, this street may or may not
            exist. So this column we handle with computed. Since this is not validated, also there
            is no props in el-form-item. 
         -->
         <el-form-item
            label="House number"
        >
            <el-input
                :model-value="houseNumber"
                disabled
                placeholder="House number"
                type="text"
                show-word-limit
                :maxlength="255"
                clearable
                @input="update()"
                @clear="update()"
                @change="update()"
            />

        </el-form-item>

        <!-- This here is not editable, it is only for displaying. Now, this street may or may not
            exist. So this column we handle with computed. Since this is not validated, also there
            is no props in el-form-item. 
         -->
         <el-form-item
            label="Zip code"
        >
            <el-input
                :model-value="zipCode"
                disabled
                placeholder="Zip code"
                type="text"
                show-word-limit
                :maxlength="255"
                clearable
                @input="update()"
                @clear="update()"
                @change="update()"
            />

        </el-form-item>

        <!-- This here is not editable, it is only for displaying. Now, this street may or may not
            exist. So this column we handle with computed. Since this is not validated, also there
            is no props in el-form-item. 
         -->
         <el-form-item
            label="City"
        >
            <el-input
                :model-value="city"
                disabled
                placeholder="City"
                type="text"
                show-word-limit
                :maxlength="255"
                clearable
                @input="update()"
                @clear="update()"
                @change="update()"
            />

        </el-form-item>



        <!-- ************************* -->

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

            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.email"
                v-text="props.errors.email"
                class="text-red-500 text-xs mt-1"
            ></div>
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
            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.rating"
                v-text="props.errors.rating"
                class="text-red-500 text-xs mt-1"
            ></div>
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
            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.tax_number"
                v-text="props.errors.tax_number"
                class="text-red-500 text-xs mt-1"
            ></div>
        </el-form-item>

        <el-form-item
            label="Customer number"
            prop="internal_cid"
        >
            <el-input
                v-model="data.customer.internal_cid"
                placeholder="Customer number"
                type="text"
                show-word-limit
                :maxlength="255"
                clearable
                @input="update()"
                @clear="update()"
                @change="update()"
            />
            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.internal_cid"
                v-text="props.errors.internal_cid"
                class="text-red-500 text-xs mt-1"
            ></div>
        </el-form-item>
    </el-form>
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import _ from 'lodash';

let props = defineProps({
    modelValue: {
        type: Object,
        required: true
    },

    /**
     * The errors object that is sent from the backend, and contains the validation errors.
     */
    errors: Object,
});

let data = reactive({
    customer: props.modelValue
});









/**
 * Customers may or may not have address related data (street, city, country, etc). So we need
 * to use computed for this. 
 * You can use the _.get function from Lodash to safely access nested properties. This function 
 * allows you to provide a path to the property you want to access and a default value to return if 
 * any part of the path is undefined
 */
let street = computed(() => {
    let street = _.get(data, 'customer.contact_addresses[0].street', '');
    if (street) {
        return data.customer.contact_addresses[0].street;
    }
    return '';
    
});

let houseNumber = computed(() => {
    let houseNumber = _.get(data, 'customer.contact_addresses[0].house_number', '');
    if (houseNumber) {
        return data.customer.contact_addresses[0].house_number;
    }
    return '';
});

let zipCode = computed(() => {
    let zipCode = _.get(data, 'customer.contact_addresses[0].zip_code', '');
    if (zipCode) {
        return data.customer.contact_addresses[0].zip_code;
    }
    return '';
});

let city = computed(() => {
    let city = _.get(data, 'customer.contact_addresses[0].city', '');
    if (city) {
        return data.customer.contact_addresses[0].city;
    }
    return '';
});



/**
 * This does the customer data synchronization with the parent CreateEditBase component. With
 * v-model magic. This is not sending a signal for saving the customer! Just the data.customer.
 */
const emit = defineEmits(['update:modelValue']);
function handleChange(){
    emit('update:modelValue', data.customer);
}



</script>

<style scoped>
</style>