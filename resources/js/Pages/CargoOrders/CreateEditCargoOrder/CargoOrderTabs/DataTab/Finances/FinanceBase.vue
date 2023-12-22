<template>
    <div>
        <div class="flex justify-between mt-6">

            <!-- TITLE -->
            <Title 
                title="Finances" 
            />

            <el-switch 
                v-model="data.showFinances"
            />

        </div>

        <!-- INPUT FIELDS START HERE.  -->
        <div 
            v-if="data.showFinances"
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
                    >Transport price net</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_transport_price_net"
                        placeholder="Transport price net"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_transport_price_net"
                />

            </el-form-item>

            <el-form-item
                prop="p_transport_price_vat"
            >   
                <div class="flex flex-col">

                    <!-- LABEL -->
                    <span
                        v-if="data.showLabel"
                        class="ml-1"
                    >Transport price vat</span>
                    
                    <!-- INPUT -->
                    <el-input
                        v-model="data.cargoOrder.p_transport_price_vat"
                        placeholder="Transport price vat"
                        clearable
                        @input="updateParent"
                    />

                </div>

                <BackendValidationErrorDisplay
                    :errorMessage="props.errors.p_transport_price_vat"
                />

            </el-form-item>



            
        </div>
    </div>

</template>

<script setup>
import { defineProps, reactive } from 'vue';
import Title from '@/Shared/Title.vue';

const props = defineProps({
    cargoOrder: {
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
    cargoOrder: props.cargoOrder,
    showFinances: true,
    showLabel: true,
});

</script>