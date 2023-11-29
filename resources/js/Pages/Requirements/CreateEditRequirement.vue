<template>
    <div>
        <el-form
            ref="ruleFormRef"
            :model="requirement"
            label-position="left"
            :rules="rules"
            label-width="120px"
        >
            <!-- Here we loop out our input field. Now this looping has two sources:
            1. requirement: this is for v-model and frontend validation.
            2. requirementFields: this is hardcoded data, for actually looping out the input fields. -->
            <el-form-item
                v-for="(inputField, index) in requirementFields"
                :key="index"
                :label="inputField.label"
                :prop="inputField.prop"
            >
                <component
                    :is="inputField.element"
                    v-model="requirement[index]"
                    :placeholder="inputField.placeholder"
                    type="text"
                    :show-word-limit="inputField.showWordLimit"
                    :maxlength="inputField.maxlength"
                    clearable
                    @input="updateSelectedCustomer()"
                    @clear="updateSelectedCustomer()"
                    @change="updateSelectedCustomer()"
                />

                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="requirementStore.errors[inputField.prop]"
                    v-text="requirementStore.errors[inputField.prop]"
                    class="text-red-500 text-xs mt-1"
                ></div>
            </el-form-item>


            <div
                class="flex flex-row"
                v-if="requirementStore.mode==='create' || requirementStore.mode==='edit' "
            >
                <!-- SUBMIT BUTTON -->
                <el-form-item class="pr-5">
                    <el-button
                        type="primary"
                        @click="submitForm(ruleFormRef)"
                    >Submit</el-button>
                </el-form-item>
                
                <!-- CANCEL BUTTON -->
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

<script setup>
import { reactive, ref, onMounted, onBeforeMount } from 'vue';
import { useRequirementStore } from '@/Stores/requirementStore';

let requirementStore = useRequirementStore();

/**
 * This contains the whole el-form. Needed for the validation.
 */
const ruleFormRef = ref();
/**
 * Here we loop out our input field. Now this looping has two sources:
    1. requirement: this is for v-model and frontend validation.
    2. requirementFields: this is hardcoded data, for actually looping out the input fields.
 */
let requirement = reactive({
    name: '',
    remarks: '',
});

/**
 * The requirement object that is being sent to the backend.
 * This line is creating a reactive object using Vue's reactive function. The reactive function is 
 * used to create a reactive and mutable object. The object is of type TmsVehicle (as defined earlier), 
 * and it's initially set with all properties as empty strings. 
 */
let requirementFields = reactive({
    name: {
        prop: 'name',
        value: '',
        element: 'el-input',
        label: 'Name',
        type: 'text',
        placeholder: 'Name',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
    remarks:{
        prop: 'remarks',
        value: '',
        element: 'el-input',
        label: 'Remarks',
        type: 'text',
        placeholder: 'Remarks',
        showWordLimit: true,
        maxlength: 255,
        clearable: true,
    },
   
});

/**
 * The validation rules for the form.
 */
const rules = reactive({
    name: [
        { required: true, message: 'Name is required FE', trigger: 'blur' },
    ],
    remarks: [
        { required: true, message: 'Remarks is required FE', trigger: 'blur' },
    ],
});

/**
 * Does the frontend validation, and if it is OK, then calls the submit() function.
 */
const emit = defineEmits(['submit']);
const submitForm = async (formEl) => {
    // console.log('validation for triggered');
    if (!formEl) return;

    await formEl.validate((valid, fields) => {
        if (valid) {//if validation is OK, then submit the requirement
            // console.log('FE validation OK, submit! This is the requirement', requirement)
            requirementStore.selectedRequirement = requirement;
            // console.log('requirementStore.selectedRequirement:', requirementStore.selectedRequirement)
            emit('submit');
            
        } else {//if validation is not OK, then show the errors
            // console.log('FE validation not OK, error submit!', fields)
            // console.log('requirement:', requirement)
            // console.log('requirementStore.selectedRequirement:', requirementStore.selectedRequirement)
        }
    })
}

/**
 * Close the popup, and resets the requirement values in this component to empty.
 */
let cancel = () => {
    requirementStore.elDialogVisible = false;
    requirementStore.selectedRequirement = requirementStore.requirementResetValues;//resetting all requirement fields
}

/**
 * Update the selectedRequirement object in store. This is needed when the mode is 'show'
 * or 'edit'. Not needed for create mode.
 */
let updateSelectedCustomer = () => {
    requirementStore.selectedRequirement = requirement;
}

/**
 * Before this component is mounted, if we are in edit mode, then we have to set the empty requirement
 * form to be = to the selectedRequirement, that has to be edited.
 */
onBeforeMount(() => {
    if (requirementStore.mode==='edit') {
        requirement = requirementStore.selectedRequirement; 
    }
});

/**
 * Creates dummy vehicles. This is only for testing purposes. 
 */
onMounted(() => {
    if (requirementStore.mode==='create') {
        requirement.name = 'BMW';
        requirement.remarks = 'This is a BMW';
    }
});

</script>

<style scoped>

</style>