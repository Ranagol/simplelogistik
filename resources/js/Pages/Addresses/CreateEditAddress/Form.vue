<template>
    <el-form
        ref="ruleFormRef"
        :model="data.addressData"
        label-position="left"
        :rules="rules"
        label-width="150px"
    >

        <!-- HEADER -->
        <div class="flex flex-row mb-2 justify-between">
            
            <!-- ADDRESS HEADER WITH BASIC ADDRESS DATA -->
            <Header
                :address="data.addressData"
            />
            
            <!-- SUBMIT BUTTON -->
            <el-form-item>
                <el-button
                    @click="submit"
                    type="primary"
                    name="button"
                >Submit</el-button>
            </el-form-item>


        </div>

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

            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.first_name"
                v-text="props.errors.first_name"
                class="text-red-500 text-xs mt-1"
            ></div>
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

            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.last_name"
                v-text="props.errors.last_name"
                class="text-red-500 text-xs mt-1"
            ></div>
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
                    v-for="(item, index) in data.addressDataTypes"
                    :key="index"
                    :label="item"
                    :value="item"
                ></el-option>
            </el-select>
                
                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="props.errors.address_type"
                    v-text="props.errors.address_type"
                    class="text-red-500 text-xs mt-1"
                ></div>
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

            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.street"
                v-text="props.errors.street"
                class="text-red-500 text-xs mt-1"
            ></div>
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

            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.house_number"
                v-text="props.errors.house_number"
                class="text-red-500 text-xs mt-1"
            ></div>
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

            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.zip_code"
                v-text="props.errors.zip_code"
                class="text-red-500 text-xs mt-1"
            ></div>
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

            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.city"
                v-text="props.errors.city"
                class="text-red-500 text-xs mt-1"
            ></div>
        </el-form-item>

        <el-form-item
            label="Country"
            prop="country"
            width="100px"
        >
            <el-input
                v-model="data.addressData.country"
                placeholder="Country"
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
                v-if="props.errors.country"
                v-text="props.errors.country"
                class="text-red-500 text-xs mt-1"
            ></div>
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

            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.state"
                v-text="props.errors.state"
                class="text-red-500 text-xs mt-1"
            ></div>
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

            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.comment"
                v-text="props.errors.comment"
                class="text-red-500 text-xs mt-1"
            ></div>
        </el-form-item>

        <el-form-item
            label="Address id"
            prop="customer_id"
            width="100px"
        >
            <el-input
                v-model="data.addressData.customer_id"
                placeholder="Address id"
                type="number"
                show-word-limit
                disabled
                :maxlength="255"
                clearable
                @input="update()"
                @clear="update()"
                @change="update()"                    
            />

            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.customer_id"
                v-text="props.errors.customer_id"
                class="text-red-500 text-xs mt-1"
            ></div>
        </el-form-item>

        <el-form-item
            label="Forwarder id"
            prop="forwarder_id"
            width="100px"
        >
            <el-input
                v-model="data.addressData.forwarder_id"
                placeholder="Forwarder id"
                type="number"
                show-word-limit
                disabled
                :maxlength="255"
                clearable
                @input="update()"
                @clear="update()"
                @change="update()"                    
            />

            <!-- BACKEND VALIDATION ERROR DISPLAY -->
            <div
                v-if="props.errors.forwarder_id"
                v-text="props.errors.forwarder_id"
                class="text-red-500 text-xs mt-1"
            ></div>
        </el-form-item>

    </el-form>
</template>

<script setup>
import { reactive, ref, onBeforeMount, watch, computed } from 'vue';
import Header from './Header.vue';

const props = defineProps({
    address: {
        type: Object,
        required: true
    },

    errors: {
        type: Object,
        required: true
    },
});

const data = reactive({
    addressData: props.address,
});

const emit = defineEmits(['update:address', 'submit']);

const update = () => {
    emit('update:address', data.addressData);
}

const submit = () => {
    emit('submit');
}




// /**
//  * This contains the whole el-form. Needed for the validation.
//  */
//  const ruleFormRef = ref()



// /**
//  * The validation rules for the form.
//  */
// const rules = reactive({
//     //empty
// })

// /**
//  * Does the frontend validation, and if it is OK, then calls the submit() function.
//  */
// const emit = defineEmits(['submit']);
// const submitForm = async (formEl) => {
//     if (!formEl) return;

//     await formEl.validate((valid, fields) => {
//         if (valid) {//if validation is OK, then submit the address
//             emit('submit');
            
//         } else {//if validation is not OK, then show the errors
//             // console.log('FE validation not OK, error submit!', fields)
//             // console.log('address:', address)
//             // console.log('customerStore.selectedCustomer:', customerStore.selectedCustomer)
//         }
//     })
// }


</script>