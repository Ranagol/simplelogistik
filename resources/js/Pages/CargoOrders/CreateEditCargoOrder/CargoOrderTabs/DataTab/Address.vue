<template>
    <div>
        <el-form-item
            label="First name"
            prop="first_name"
        >
            <el-input
                v-model="data.address.first_name"
                placeholder="First name"
                clearable
            />
        </el-form-item>
        
    </div>
</template>

<script setup>
import { ref, reactive, computed, watch, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
    address: {
        type: Object,

        /**
         * Returns an empty address object, if the order does not has one.
         */
         default: () => ({
            first_name: 'Random text',
            last_name: 'Random text',
            address_type: 'Main headquarters',
            street: "Random text",
            house_number: 'Random text',
            zip_code: "Random text",
            city: "Random text",
            country: "Random text",
            state: 'Random text',
            type_of_address: '',
            comment: 'Random text',
            customer_id: 1,
            forwarder_id: 1,
        }),
    },

    /**
     * The errors object that is sent from the backend, and contains the validation errors.
     */
    errors: Object,

    /**
     * The mode of the form.
     */
    mode: String,

});

const data = reactive({
    address: props.address,
});

</script>