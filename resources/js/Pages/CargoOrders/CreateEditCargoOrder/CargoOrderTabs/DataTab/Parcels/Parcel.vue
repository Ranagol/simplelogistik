<template>
    <el-form
        :data="data.parcel"
        ref="parcelForm"
        class="card-header flex flex-row"
    >
        <!-- NUMBER OF THE PARCEL IN THE LIST -->
        <el-form-item>
            <span>{{ index + 1 }}</span>
        </el-form-item>

        <!-- PARCEL TYPE -->
        <el-form-item
            prop="p_name"
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
        <el-form-item>
            <el-button
                type="primary"
                icon="el-icon-plus"
                circle
                size="mini"
                @click="duplicateParcel"
            ></el-button>

            <el-button
                type="primary"
                icon="el-icon-plus"
                circle
                size="mini"
                @click="duplicateParcelNumeric"
            ></el-button>

            <el-button
                type="danger"
                icon="el-icon-delete"
                circle
                size="mini"
                @click="deleteParcel"
            ></el-button>
        </el-form-item> 

    </el-form>
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import BackendValidationErrorDisplay from '@/Shared/Validation/BackendValidationErrorDisplay.vue';


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

    errors: {
        type: Object,
        required: true,
    },

    /**
     * We use this index simply to render the order number in the list. Like first parcel, 
     * second parcel, etc.
     */
    index: {
        type: Number,
        required: true,
    },
});

let data = reactive({
    parcel: props.parcel,
});

const update = () => {
    console.log('update triggered');
}


</script>

<style scoped>
</style>
