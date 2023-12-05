<template>

    <Head
        :title="props.mode"
    />

    <pre>{{ JSON.stringify(data.addressData, null, 2) }}</pre>

    <!-- EDIT ADDRESS -->
    <Card>
        
        <!-- ADDRESS HEADER WITH BASIC ADDRESS DATA -->
        <Header
            :address="data.addressData"
        />

        <ButtonSubmitTab
            @submit="submit"
        />

        <el-form
            ref="ruleFormRef"
            :model="data.addressData"
            label-position="left"
            :rules="rules"
            label-width="150px"
        >
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
                    v-if="props.errors.company_name"
                    v-text="props.errors.company_name"
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
                        v-for="(item, index) in props.addressTypes"
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
    </Card>
</template>

<script setup>
import { reactive, ref, onBeforeMount, watch, computed } from 'vue';
import ButtonSubmitTab from '@/Shared/ButtonSubmitTab.vue';
import Card from '@/Shared/Card.vue';
import { router } from '@inertiajs/vue3';
import Header from './Header.vue';

const props = defineProps({

    /**
     * The address object.
     */
    record: {
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
     * The address types that are defined in TmsAddress model. The backend is sending this data here.
     */
    addressTypes: {
        type: Object,
        required: true
    },

    

    /**
     * The errors object that is sent from the backend, and contains the validation errors.
     */
    errors: Object,
});

/**
 * This watcher simply helps to validation errors from props.errors to go to the child components.
 * For some reason this is not reactive enough without the computed.
 */
let errorsComputed = computed(() => {
    return props.errors;
});



const data = reactive({

    /**
     * The address object.
     */
    addressData: props.record
});

const submit = () => {
    console.log('submit');
    if (props.mode === 'edit') {
        edit();
    } else {
        create();
    }
}

const edit = () => {
    router.put(
        `/addresses/${data.addressData.id}`, 
        data.addressData,
        {
            onSuccess: () => {
                ElMessage({
                    message: 'Address edited successfully',
                    type: 'success',
                });
                router.reload({ only: ['record'] })
            },
            onError: (errors) => {
                ElMessage.error('Oops, something went wrong while editing a address.')
                ElMessage(errors);
            }
        }
    )
};

// const create = () => {
//     router.post(
//         '/addresses', 
//         customerStore.selectedCustomer, 
//         {
//             onSuccess: () => {
//                 ElMessage({
//                     message: 'Address created successfully',
//                     type: 'success',
//                 });
//                 // get addresses again, so that the new address is displayed
//                 router.reload({ only: ['dataFromController'] })
//                 customerStore.elDialogVisible = false;
//             },
//             onError: (errors) => {
//                 ElMessage.error('Oops, something went wrong while creating a new address.')
//                 ElMessage(errors);
//             }
//         }
//     )
// };


/**
 * This contains the whole el-form. Needed for the validation.
 */
 const ruleFormRef = ref()

/**
 * The address object that is being sent to the backend.
 * This line is creating a reactive object using Vue's reactive function. The reactive function is 
 * used to create a reactive and mutable object. The object is of type RuleForm (as defined earlier), 
 * and it's initially set with all properties as empty strings. 
 */
 let address = reactive({
    //Use this for creating a new address
    // company_name: '',
    // name: '',
    // email: '',
    // rating: '',
    // tax_number: '',
    // internal_cid: '',

    //Use this to stamp addresses during development
    // company_name: 'Dummy from Create',
    // name: 'sdfv',
    // email: 'bla@gmail.com',
    // rating: '5',
    // tax_number: '5555',
    // internal_cid: '66666',
})

/**
 * The validation rules for the form.
 */
const rules = reactive({
    //empty
})

/**
 * Does the frontend validation, and if it is OK, then calls the submit() function.
 */
const emit = defineEmits(['submit']);
const submitForm = async (formEl) => {
    if (!formEl) return;

    await formEl.validate((valid, fields) => {
        if (valid) {//if validation is OK, then submit the address
            emit('submit');
            
        } else {//if validation is not OK, then show the errors
            // console.log('FE validation not OK, error submit!', fields)
            // console.log('address:', address)
            // console.log('customerStore.selectedCustomer:', customerStore.selectedCustomer)
        }
    })
}

/**
 * Resets the address values in this component to empty.
 */
let cancel = () => {
}

/**
 * Update the selectedCustomer object in store. This is needed when the mode is 'show'
 * or 'edit'. Not needed for create mode.
 */
let update = () => {
    
}




</script>

<style scoped>

</style>