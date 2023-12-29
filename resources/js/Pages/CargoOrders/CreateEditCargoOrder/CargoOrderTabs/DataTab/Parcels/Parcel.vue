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
                @change="update"
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
                @change="update"
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
                @change="update"
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
                @change="update"
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
                @change="update"
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
                @change="update"
            />

            <BackendValidationErrorDisplay
                :errorMessage="props.errors.p_weight"
            />

        </el-form-item>

        <!-- DUPLICATE, NUMERIC DUPLICATE, DELETE -->
        <el-form-item
            class="w-60 pl-2"

        >
            <el-button
                type="primary"
                size="small"
                @click="duplicateParcel"
                class="mr-2"
            >
                <el-icon><CopyDocument /></el-icon>
            </el-button>

            <el-input
                v-model="data.parcel.duplicateNumeric"
                :min="1"
                :max="100"
                :step="1"
                size="small"
                style="width: 60px"
                @change="update"
                class="mr-2"
            />

            <el-button
                type="danger"
                size="small"
                @click="deleteParcel"
                class="mr-2"
            >
                <el-icon><Delete /></el-icon>
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
});

const emit = defineEmits(['updateParcel', 'duplicateParcel', 'deleteParcel']);



const update = () => {
    console.log('update triggered');
}

const duplicateParcel = () => {
    console.log('duplicateParcel triggered');
}

const deleteParcel = () => {
    console.log('deleteParcel triggered');
    emit('deleteParcel', props.index);
}


</script>

<style scoped>
</style>
