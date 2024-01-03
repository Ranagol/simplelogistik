<template>
    <el-form
        ref="ruleFormRef"
        :model="data.order"
        label-position="left"
        label-width="150px"
    >   
        <!-- HEADER -->
        <div class="flex flex-row mb-2 justify-between">
            
            <!-- TITLE -->
            <h1
                class="font-semibold text-xl text-gray-800 leading-tight mr-6"
            >{{ _.capitalize(props.mode)}}</h1>
            
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

        <!-- INPUT FIELDS -->
        <div>

        </div>

        <pre>{{ JSON.stringify(props.order, null, 2) }}</pre>  

    </el-form>


</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import _ from 'lodash';

let props = defineProps({

    /**
     * The carogOrder object.
     */
    order: {
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
    order: props.order
});

/**
 * This does the customer data synchronization with the parent CreateEditBase component. With
 * v-model magic. This is not sending a signal for saving the customer! Just the data.customer.
 */
 const emit = defineEmits(['update:order', 'submit', 'destroy']);

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