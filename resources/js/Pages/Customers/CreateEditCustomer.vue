<template>
    <div>

        <!--  -->
        <el-form
            ref="ruleFormRef"
            :model="customer"
            label-position="top"
            :rules="rules"
        >
            <el-form-item
                label="Company name"
                prop="company_name"
                width="100px"
            >
                <el-input
                    v-model="customer.company_name"
                    placeholder="Company name"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    :disabled="mode==='show'"
                    @input="updateSelectedCustomer()"
                    @clear="updateSelectedCustomer()"
                    @change="updateSelectedCustomer()"
                />

                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="props.errors.company_name"
                    v-text="props.errors.company_name"
                    class="text-red-500 text-xs mt-1"
                ></div>
            </el-form-item>

            <el-form-item
                label="Name"
                prop="name"
            >
                <el-input
                    v-model="customer.name"
                    placeholder="Name"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    :disabled="mode==='show'"
                    @input="updateSelectedCustomer()"
                    @clear="updateSelectedCustomer()"
                    @change="updateSelectedCustomer()"
                />

                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="props.errors.name"
                    v-text="props.errors.name"
                    class="text-red-500 text-xs mt-1"
                ></div>
            </el-form-item>

            <el-form-item
                label="Email"
                prop="email"
            >
                <el-input
                    v-model="customer.email"
                    placeholder="Email"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    :disabled="mode==='show'"
                    @input="updateSelectedCustomer()"
                    @clear="updateSelectedCustomer()"
                    @change="updateSelectedCustomer()"
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
                    v-model="customer.rating"
                    placeholder="Rating"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    :disabled="mode==='show'"
                    @input="updateSelectedCustomer()"
                    @clear="updateSelectedCustomer()"
                    @change="updateSelectedCustomer()"
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
                    v-model="customer.tax_number"
                    placeholder="Tax number"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    :disabled="mode==='show'"
                    @input="updateSelectedCustomer()"
                    @clear="updateSelectedCustomer()"
                    @change="updateSelectedCustomer()"
                />
                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="props.errors.tax_number"
                    v-text="props.errors.tax_number"
                    class="text-red-500 text-xs mt-1"
                ></div>
            </el-form-item>

            <el-form-item
                label="Internal CID"
                prop="internal_cid"
            >
                <el-input
                    v-model="customer.internal_cid"
                    placeholder="Internal CID"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                    clearable
                    :disabled="mode==='show'"
                    @input="updateSelectedCustomer()"
                    @clear="updateSelectedCustomer()"
                    @change="updateSelectedCustomer()"
                />
                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="props.errors.internal_cid"
                    v-text="props.errors.internal_cid"
                    class="text-red-500 text-xs mt-1"
                ></div>
            </el-form-item>

            <!-- BUTTONS will be displayed in create and edit mode, and will not be displayed
            in show mode.-->
            <div
                class="flex flex-row"
                v-if="props.mode==='create' || props.mode==='edit' "
            >
                <el-form-item class="pr-5">
                    <el-button
                        type="primary"
                        @click="submitForm(ruleFormRef)"
                    >Submit</el-button>
                </el-form-item>
    
                <el-form-item class="pr-5">
                    <el-button
                        type="danger"
                        @click="cancel"
                    >Cancel</el-button>
                </el-form-item>

            </div>
        </el-form>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref, watch } from 'vue';
import type { FormInstance, FormRules } from 'element-plus'
import { router } from '@inertiajs/vue3'

let props = defineProps({ 
    /**
     * The errors are being sent from the Customers/Index grandparent component, because for some reason
     * they are not arriving here. Possibly because this is a deeply nested el-dialog, and not a compnent
     * that has a fix place and not disappears.
     */
    errors: Object, 

    /**
     * The selected customer object from the parent Index.vue. This is passed to the child 
     * CreateEditCustomer.vue. Needed when the mode is 'show' or 'edit'. Not needed for create 
     * mode.
     */
    selectedCustomer: Object,

    /**
     * This is passed to the child CreateEditCustomer.vue. It could be 
     * 'create', 'show' or 'edit'. This is important, because the input fields must be disabled when
     * mode = 'show'.
     */
    mode: String,

});

/**
 * Here we define, what structure should have the customer object.
 */
interface RuleForm {
    company_name: string,
    name: string,
    email: string,
    rating: string,
    tax_number: string,
    internal_cid: string,
}

/**
 * The ref function is used to create a reactive and mutable object reference. The type of the 
 * reference is FormInstance, which is not defined in the provided code but is likely a type or 
 * interface that represents the form instance.
 * Possibly this contains the whole el-form?
 */
const ruleFormRef = ref<FormInstance>()

/**
 * The customer object that is being sent to the backend.
 * This line is creating a reactive object using Vue's reactive function. The reactive function is 
 * used to create a reactive and mutable object. The object is of type RuleForm (as defined earlier), 
 * and it's initially set with all properties as empty strings. 
 */
let customer = reactive<RuleForm>({
    company_name: '',
    name: '',
    email: '',
    rating: '',
    tax_number: '',
    internal_cid: '',
})


/**
 * The validation rules for the form.
 */
const rules = reactive<FormRules<RuleForm>>({
    company_name: [
        { required: true, message: 'Company name is required FE', trigger: 'blur' },
        { min: 3, max: 100, message: 'Length should be 3 to 100', trigger: 'blur' },
    ],
    name: [
            { required: true, message: 'Name is required FE', trigger: 'blur' },
        ],
    email: [
        { required: true, message: 'Email is required FE', trigger: 'blur' },
    ],
    // rating: [
    //     { required: true, message: 'Rating is required FE', trigger: 'blur' },
    // ],
    tax_number: [
        { required: true, message: 'Tax number is required FE', trigger: 'blur' },
    ],
    internal_cid: [
        { required: true, message: 'Internal CID is required FE', trigger: 'blur' },
    ],
})

/**
 * Does the frontend validation, and if it is OK, then calls the submitCustomer() function.
 * 
 * @param formEl 
 */
const submitForm = async (formEl: FormInstance | undefined) => {
    if (!formEl) return;

    await formEl.validate((valid, fields) => {
        if (valid) {
            // console.log('Validation OK, submit!', customer)
            //Triggers the submitCustomer() method in the parent Index.vue
            emit('submitCustomer', customer);
            
        } else {
            // console.log('FE validation not OK, error submit!', fields)
        }
    })
}

const emit = defineEmits(
    [
        'closePopup', 
        'submitCustomer',
        'update:selectedCustomer',
        'resetEditedCustomer'
    ]
);

/**
 * Close the popup, by emitting the closePopup event. This will trigger the closePopup method in
 * the in Popup.vue. Which will set in Index.vue the elDialogVisible to false, and the popup will
 * close. Triggered by the Cancel button.
 * 
 * PROBLEM: When editing the customer (example the name), not submitting, but canceling, then in 
 * the list will be the edited, unfinished, unsubmitted new name, till the next page refresh.
 * 
 * SOLUTION: we emit the resetEditedCustomer event, which will trigger the resetEditedCustomer in
 * grandparent Index.vue, and this will reload all the customers. Whic will correct this issue
 */
let cancel = () => {
    emit('resetEditedCustomer');
    emit('closePopup');
}

/**
 * Update the selectedCustomer object in the parent Index.vue. This is needed when the mode is 'show'
 * or 'edit'. Not needed for create mode.
 * 
 * @param customer 
 */
let updateSelectedCustomer = () => {
    emit('update:selectedCustomer', customer);
}

watch(
    () => props.selectedCustomer,
    (newValue, oldValue) => {
        customer = newValue;
    },
    { immediate: true,},
);

</script>

<style scoped>

</style>