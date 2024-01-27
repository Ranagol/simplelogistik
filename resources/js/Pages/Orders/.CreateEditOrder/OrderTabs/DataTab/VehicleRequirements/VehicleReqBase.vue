<template>
    <div>
        <div class="flex justify-between mt-6">

            <!-- TITLE -->
            <Title 
                title="Vehicle requirements" 
            />

            <el-switch 
                v-model="data.showVehicleReq"
            />

        </div>

        <!-- INPUT FIELDS START HERE.  -->
        <div 
            v-if="data.showVehicleReq"
            class="grid grid-cols-3 gap-4 mt-4"
        >

            <el-form-item
                prop="p_transport_price_net"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >WORK IN PROGRESS - NOT DONE</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.order.p_transport_price_net"
                        placeholder="Transport price net"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_transport_price_net"
                />

            </el-form-item>
        </div>
    </div>

</template>

<script setup>
import { defineProps, reactive } from 'vue';
import Title from '@/Shared/Title.vue';
import BackendValidationErrorDisplay from '@/Shared/Validation/BackendValidationErrorDisplay.vue';

const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
    mode: {
        type: String,
        required: true,
    },
});

const data = reactive({
    order: props.order,
    showVehicleReq: true,
    showLabel: true,
});

</script>