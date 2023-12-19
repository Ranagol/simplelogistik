<template>
    <!-- HEADER -->
    <div class="flex flex-row mb-2 justify-between">
            
        <!-- TITLE -->
        <h1
            class="text-gray-500 leading-tight mr-6"
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
                @click="console.log('cancel order clicked, but no further steps are implemented yet')"
                type="danger"
            >Cancel order</el-button>
        </el-form-item>

    </div>
</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import _ from 'lodash';

const props = defineProps({

    /**
     * mode is either 'create' or 'edit'. This is decided in the controller. This component will
     * behave differently depending on which mode is it.
     */
     mode: {
        type: String,
        required: true
    },
})

const emit = defineEmits(['submit', 'destroy']);

const submit = () => {
    // console.log('submit from Header.vue');
    emit('submit');
}

const destroy = () => {
    emit('destroy');
}

</script>