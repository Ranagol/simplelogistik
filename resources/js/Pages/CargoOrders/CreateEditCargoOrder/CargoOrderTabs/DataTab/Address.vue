<template>
    <div class="mt-4">

        <div class="mb-2">{{ props.pickupOrDelivery }} address</div>

        <!-- COMPANY NAME, 1 FULL ROW -->
        <el-form-item
            prop="company_name"
        >
            <el-input
                v-model="data.address.company_name"
                placeholder="Company name"
                type="text"
                
                :maxlength="255"
                
                @input="update()"
                @clear="update()"
                @change="update()"
            />
        </el-form-item>

        <!-- ROWS WITH TWO COLUMNS -->
        <div class="grid grid-rows">
            
            <!-- FIRST NAME AND LAST NAME -->
            <div class="grid grid-cols-2">

                <!-- FIRST NAME -->
                <el-form-item
                    prop="first_name"
                >
                    <el-input
                        v-model="data.address.first_name"
                        placeholder="First name"
                        type="text"
                        
                        :maxlength="255"
                        
                        @input="update()"
                        @clear="update()"
                        @change="update()"
                        class="mr-1"
                    />
                </el-form-item>

                <!-- LAST NAME -->
                <el-form-item
                    prop="last_name"
                >
                    <el-input
                        v-model="data.address.last_name"
                        placeholder="Last name"
                        type="text"
                        
                        :maxlength="255"
                        
                        @input="update()"
                        @clear="update()"
                        @change="update()"
                        class="ml-1"
                    />
                </el-form-item>
            </div>

            <!-- STREET AND HOUSE NUMBER -->
            <div class="grid grid-cols-2">

                <!-- STREET -->
                <el-form-item
                    prop="street"
                >
                    <el-input
                        v-model="data.address.street"
                        placeholder="Street"
                        type="text"
                        
                        :maxlength="255"
                        
                        @input="update()"
                        @clear="update()"
                        @change="update()"
                        class="mr-1"
                    />
                </el-form-item>

                <!-- HOUSE NUMBER -->
                <el-form-item
                    prop="house_number"
                >
                    <el-input
                        v-model="data.address.house_number"
                        placeholder="House number"
                        type="text"
                        
                        :maxlength="255"
                        
                        @input="update()"
                        @clear="update()"
                        @change="update()"
                        class="ml-1"
                    />
                </el-form-item>
            </div>

            <!-- ZIP CODE AND CITY -->
            <div class="grid grid-cols-2">

                <!-- ZIP CODE -->
                <el-form-item
                    prop="zip_code"
                >
                    <el-input
                        v-model="data.address.zip_code"
                        placeholder="Zip code"
                        type="text"
                        
                        :maxlength="255"
                        
                        @input="update()"
                        @clear="update()"
                        @change="update()"
                        class="mr-1"
                    />
                </el-form-item>

                <!-- CITY -->
                <el-form-item
                    prop="city"
                >
                    <el-input
                        v-model="data.address.city"
                        placeholder="City"
                        type="text"
                        
                        :maxlength="255"
                        
                        @input="update()"
                        @clear="update()"
                        @change="update()"
                        class="ml-1"
                    />
                </el-form-item>
            </div>

            <!-- STATE AND COUNTRY -->
            <div class="grid grid-cols-2">

                <!-- STATE -->
                <el-form-item
                    prop="state"
                >
                    <el-input
                        v-model="data.address.state"
                        placeholder="State"
                        type="text"
                        
                        :maxlength="255"
                        
                        @input="update()"
                        @clear="update()"
                        @change="update()"
                        class="mr-1"
                    />
                </el-form-item>

                <!-- COUNTRY -->
                <el-form-item
                    prop="country"
                >
                    <el-input
                        v-model="data.address.country_code"
                        placeholder="Should we put here something?"
                        type="text"
                        
                        :maxlength="255"
                        
                        @input="update()"
                        @clear="update()"
                        @change="update()"
                        class="ml-1"
                    />
                </el-form-item>
            </div>



            
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed, watch, onMounted, onBeforeUnmount } from 'vue';
import addressDummy from '@/Pages/Addresses/CreateEditAddress/addressDummy';//use this in props to have already filled address form for creating new address
import addressEmpty from '@/Pages/Addresses/CreateEditAddress/addressEmpty';//use this in props to have empty address form for creating new address

const props = defineProps({
    address: {
        type: Object,

        /**
         * Returns an empty address object, if the order does not has one.
         */
         default: () => (addressDummy),
    },

    /**
     * The errors object that is sent from the backend, and contains the validation errors.
     */
    errors: Object,

    /**
     * The mode of the form.
     */
    mode: String,

    /**
     * The pickupOrDelivery prop is either 'pickup' or 'delivery'. This is needed for the component 
     * title to render.
     */
    pickupOrDelivery: String,

});

const data = reactive({
    address: props.address,
});

const emit = defineEmits(['update:address']);

/**
 * Only updates the parent's address object. No triggering of submit or edit. No need for validation.
 */
const update = () => {
    emit('update:address', data.addressData);
}

</script>