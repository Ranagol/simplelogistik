<template>
    <el-form
        :data="data.parcel"
        ref="parcelForm"
        class="card-header flex flex-row mt-2"
    >
        <!-- NUMBER OF THE PARCEL IN THE LIST -->
        <el-form-item
            class="w-8"
        >
            <span>{{ index + 1 }}</span>
        </el-form-item>

        <!-- PARCEL TYPE -->
        <el-form-item
            prop="p_name"
            class="w-1/6 pr-2"
        >   
            <el-select
                v-model="data.parcel.p_name"
                placeholder="Parcel type"
                clearable
                filterable
                style="width: 100%"
            >
                <el-option
                    v-for="(item, index) in props.parcelTypes"
                    :key="index"
                    :label="item"
                    :value="item"
                ></el-option>
            </el-select>

            
            <BackendValidationErrorDisplay
                :errorMessage="props.errors.p_name"
            />

        </el-form-item>

        <!-- ORDER CONTENT -->
        <el-form-item
            prop="information"
            class="w-1/3 pr-2"
        >
            <el-input
                v-model="data.parcel.information"
                placeholder="Order content"
                clearable
                style="width: 100%"
            />

            <BackendValidationErrorDisplay
                :errorMessage="props.errors.information"
            />

        </el-form-item>

        <!-- LENGTH -->
        <el-form-item
            prop="p_length"
            class="w-1/12 pr-2"
        >
            <el-input
                v-model="data.parcel.p_length"
                placeholder="Length cm"
                clearable
                style="width: 100%"
            />

            <BackendValidationErrorDisplay
                :errorMessage="props.errors.p_length"
            />

        </el-form-item>

        <!-- WIDTH -->
        <el-form-item
            prop="p_width"  
            class="w-1/12 pr-2"
        >
            <el-input
                v-model="data.parcel.p_width"
                placeholder="Width cm"
                clearable
                style="width: 100%"
            />

            <BackendValidationErrorDisplay
                :errorMessage="props.errors.p_width"
            />
            
        </el-form-item>

        <!-- HEIGHT -->
        <el-form-item
            prop="p_height"
            class="w-1/12 pr-2"
        >
            <el-input
                v-model="data.parcel.p_height"
                placeholder="Height cm"
                clearable
                style="width: 100%"
            />

            <BackendValidationErrorDisplay
                :errorMessage="props.errors.p_height"
            />

        </el-form-item>

        <!-- WEIGHT -->
        <el-form-item
            prop="p_weight"
            class="w-1/12 pr-2"
        >
            <el-input
                v-model="data.parcel.p_weight"
                placeholder="Weight kg"
                clearable
                style="width: 100%"
            />

            <BackendValidationErrorDisplay
                :errorMessage="props.errors.p_weight"
            />

        </el-form-item>

        <!-- DUPLICATE, NUMERIC DUPLICATE, DELETE -->
        <el-form-item
            class="w-60 pl-2"

        >
            <!-- NUMBER INPUT FIELD FOR THE NUMERIC DUPLICATION -->
            <el-input-number
                v-model="data.duplicationAmount"
                :min="1"
                :max="100"
                :step="1"
                controls-position="right"
                style="width: 80px"
                class="mr-2"
            />

            <!-- BUTTON FOR TRIGGERING THE NUMERIC DUPLICATION -->
            <el-button
                type="primary"
                @click="duplicateParcel"
            >
                <el-icon>
                    <CopyDocument />
                </el-icon>
            </el-button>

            <!-- DELETE PARCEL BUTTON -->
            <el-button
                type="danger"
                @click="deleteParcel"
            >
                <el-icon>
                    <Delete />
                </el-icon>
            </el-button>
            
        </el-form-item> 

    </el-form>
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import BackendValidationErrorDisplay from '@/Shared/Validation/BackendValidationErrorDisplay.vue';
import { Delete, CopyDocument } from '@element-plus/icons-vue';

let props = defineProps({
    parcel: {
        type: Object,
        required: true,
    },

    /**
     * Select options for parcel types. Will be used with el-select.
     */
    parcelTypes: {
        type: Array,
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
     */
    errors: {
        type: Object,
        required: true,
    },

    /**
     * We use this index simply to render the order number in the list. Like first parcel, 
     * second parcel, etc.
     * We also use this index for the validation error display. See the comments for the errors.
     */
    index: {
        type: Number,
        required: true,
    },
});

let data = reactive({
    parcel: props.parcel,
    duplicationAmount: 1,
});

const emit = defineEmits(['updateParcel', 'duplicateParcel', 'deleteParcel']);



const update = () => {
    console.log('update triggered');
}

/**
 * Sends a sign to the parent component to create the given amount of numeric duplications for the
 * selected parcel. The duplication amount shows how many times the parcel should be duplicated.
 * The current parcel's data will be used for the duplication, so the new duplicated parcels will
 * have the same data as the current parcel.
 */
const duplicateParcel = () => {
    emit('duplicateParcel', data.duplicationAmount, data.parcel);
}

/**
 * Sends a sign to the parent component to delete the parcel.
 */
const deleteParcel = () => {
    emit('deleteParcel', props.index);
}


</script>

<style scoped>
</style>
