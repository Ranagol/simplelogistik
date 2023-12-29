<template>
    <el-card class="box-card">

        <!-- HEADER -->
        <template #header>
            <div class="card-header flex flex-row">
                <span class="w-8">#</span>
                <span class="w-1/6 pl-2">Parcel type</span>
                <span class="w-1/3 pl-2">Order content</span>
                <span class="w-1/12 pl-2">Length cm</span>
                <span class="w-1/12 pl-2">Width cm</span>
                <span class="w-1/12 pl-2">Height cm</span>
                <span class="w-1/12 pl-2">Weight kg</span>
                <span class="w-60 pl-2">Actions</span>
            </div>
        </template>

        <!-- LIST OF PARCELS, done with v-for -->
        <!-- v-model:parcel="data.parcels[index]"   this must be done like this, do not replace this 
        with simple parcel -->
        <div>
            <Parcel
                v-for="(parcel, index) in data.parcels"
                :key="index"
                :index="index"
                v-model:parcel="data.parcels[index]"
                :parcelTypes="props.selectOptions.parcelTypes"
                :errors="filterValidationError(index)"
                @deleteParcel="deleteParcel(index)"
                @duplicateParcel="duplicateParcel"
            />
        </div>

        <!-- ADD PARCEL BUTTON -->
        <div class="card-actions flex flex-row justify-center">
            <el-button
                type="primary"
                @click="addParcel"
            >   
                <el-icon><Plus /></el-icon> 
                <!-- &nbsp; is a simple empty space between words -->
                &nbsp; Add empty parcel
            </el-button>   
        </div>

    </el-card>
    
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import Parcel from './Parcel.vue';
import { Plus } from '@element-plus/icons-vue';
import _ from 'lodash';

let props = defineProps({

    parcels: {
        type: Array,
        required: true,
    },

    selectOptions: {
        type: Object,
        required: true,
    },

    /**
     * Errors for the parcel. Will be used with BackendValidationErrorDisplay. However, here we
     * have an additional level of complexity. There could be multiple parcels, so we need to
     * display the errors for each parcel. The errors object will look like this (in case if the
     * object has two parcels, and for both parcels the p_name field is required in validation but
     * missing in the request (so the error will be the same for both parcels)):
     * 
     * "props": {
        "errors": {
            "parcels.0.p_name": "The parcels.0.p_name field is required.",
            "parcels.1.p_name": "The parcels.1.p_name field is required."
        },
     * 
     * 
     * So we need to pass the errors for the current parcel to the BackendValidationErrorDisplayt.
     * We will do this by passing the errors object to the parcel component and then filtering
     * the errors object by the parcel index.
     * To achieve this, we will use computed property, filteredValidationError().
     */
    errors: {
        type: Object,
        required: true,
    },
});

let data = reactive({
    parcels: props.parcels,
});

/**
 * See props.errors for the explanation.
 * index is created in the v-for loop in the template. We use it here to filter the errors, so the
 * right Parcel component receives the right errors.
 */
const filterValidationError = (index) => {

    //The filtered errors will be here in the end.
    let filteredErrors = {};

    //We loop through all the error object properties. 
    for (const [key, value] of Object.entries(props.errors)) {
        // console.log('key:', key);//Example: parcels.0.p_name
        // console.log('value:', value);//Example: The parcels.0.p_name field is required.

        //This is where we filter the right error for the right parcel.
        if (key.includes(`parcels.${index}`)) {
            
            /**
             * We need to remove the "parcels.0." part from the key, so the key will be "p_name" 
             * instead of "parcels.0.p_name".
             * We will use the key to display the error message for the right field.
             */
            const newKey = key.replace(`parcels.${index}.`, '');
            // console.log('newKey:', newKey);//Example: p_name 
            filteredErrors[newKey] = value;
        }
    }

    return filteredErrors;
};

/**
 * Adds one new parcel to the list of parcels.
 * Reminder: this is just a frontend addition. On order to add this parcel to the database,
 * the user must submit the form. Logic for this is in the CreateEditOrder.vue.
 */
const addParcel = () => {
    data.parcels.push({
        p_type: null,
        p_name: null,
        p_length: null,
        p_width: null,
        p_height: null,
        p_weight: null,
    });
};

/**
 * Deletes one parcel from the list of parcels.
 * index is created in the v-for loop in the template. We use it here to delete the right parcel.
 * Reminder: this is just a frontend deletion. On order to delete this parcel from the database,
 * the user must submit the form. Logic for this is in the CreateEditOrder.vue.
 */
const deleteParcel = (index) => {
    data.parcels.splice(index, 1);
};  

/**
 * This does the parcel numerical duplication. The duplication amount shows how many times the
 * parcel should be duplicated. The current parcel's data will be used for the duplication, so the
 * new duplicated parcels will have the same data as the current parcel.
 * Reminder: this is just a frontend duplication. On order to duplicate this parcel in the database,
 * the user must submit the form. Logic for this is in the CreateEditOrder.vue.
 */
const duplicateParcel = (duplicationAmount, parcel) => {
    //We must create a completely new parcel object, otherwise the original parcel will be changed.
    const newParcel = {...parcel};
    //The original parcel id must be removed from clone parcels, otherwise the backend will throw an error.
    newParcel.id = null;
    //Here we create the given amount of new parcels.
    for (let i = 0; i < duplicationAmount; i++) {
        data.parcels.push(newParcel);
    }
};




</script>

<style scoped>
</style>
