<template>
    <div class="mt-4">

        <div
            class="flex justify-between"
        >
            <!-- SUBTITLE -->
            <div 
                class="mb-4 font-bold"
            >{{ props.title }} address</div>

            <!-- BUTTON FOR ADDING MORE, ADDITIONAL ADDRESSES -->
            <el-button
                v-if="props.title === 'Delivery' || props.title === 'Pickup'"
                type="success"
                size="mini"
            >+</el-button>

        </div>

        <!-- COMPANY NAME, 1 FULL ROW -->
        <el-form-item
            prop="company_name"
        >
            <div class="flex flex-col grow">

                <!-- LABEL -->
                <span
                    v-if="data.showLabel"
                    class="ml-1"
                >Company name</span>

                <el-input
                    v-model="data.address.company_name"
                    placeholder="Company name"
                    type="text"
                    :maxlength="255"
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />
                
            </div>

        </el-form-item>

        <!-- ROWS WITH TWO COLUMNS -->
        <div class="grid grid-rows">
            
            <!-- FIRST NAME AND LAST NAME -->
            <div class="grid grid-cols-2">

                <!-- FIRST NAME -->
                <el-form-item
                    prop="first_name"
                >
                    <div class="flex flex-col grow">

                        <!-- LABEL -->
                        <span
                            v-if="data.showLabel"
                            class="ml-1"
                        >First name</span>

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

                    </div>

                </el-form-item>

                <!-- LAST NAME -->
                <el-form-item
                    prop="last_name"
                >

                    <div class="flex flex-col grow">

                        <!-- LABEL -->
                        <span
                            v-if="data.showLabel"
                            class="ml-1"
                        >Last name</span>

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

                    </div>

                </el-form-item>
            </div>

            <!-- STREET AND HOUSE NUMBER -->
            <div class="grid grid-cols-2">

                <!-- STREET -->
                <el-form-item
                    prop="street"
                >

                    <div class="flex flex-col grow">

                        <!-- LABEL -->
                        <span
                            v-if="data.showLabel"
                            class="ml-1"
                        >Street</span>

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

                    </div>

                </el-form-item>

                <!-- HOUSE NUMBER -->
                <el-form-item
                    prop="house_number"
                >

                    <div class="flex flex-col grow">

                        <!-- LABEL -->
                        <span
                            v-if="data.showLabel"
                            class="ml-1"
                        >House number</span>

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

                    </div>

                </el-form-item>
            </div>

            <!-- ZIP CODE AND CITY -->
            <div class="grid grid-cols-2">

                <!-- ZIP CODE -->
                <el-form-item
                    prop="zip_code"
                >

                    <div class="flex flex-col grow">

                        <!-- LABEL -->
                        <span
                            v-if="data.showLabel"
                            class="ml-1"
                        >Zip code</span>

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

                    </div>

                </el-form-item>

                <!-- CITY -->
                <el-form-item
                    prop="city"
                >

                    <div class="flex flex-col grow">

                        <!-- LABEL -->
                        <span
                            v-if="data.showLabel"
                            class="ml-1"
                        >City</span>

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

                    </div>

                </el-form-item>
            </div>

            <!-- STATE AND COUNTRY -->
            <div class="grid grid-cols-2">

                <!-- STATE -->
                <el-form-item
                    prop="state"
                >

                    <div class="flex flex-col grow">

                        <!-- LABEL -->
                        <span
                            v-if="data.showLabel"
                            class="ml-1"
                        >State</span>

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

                    </div>

                </el-form-item>

                <!-- COUNTRY ******************************************-->
                <el-form-item
                    prop="country"
                >

                    <div class="flex flex-col grow">

                        <!-- LABEL -->
                        <span
                            v-if="data.showLabel"
                            class="ml-1"
                        >Country</span>

                        <!-- This el-select works with a whole object. Syncs a whole object. -->
                        <el-select
                            v-model="data.address.country.country_name"
                            clearable
                            filterable
                            value-key="id"
                            @change="update()"
                            class="ml-1"
                        >
                            <el-option
                                v-for="(item, index) in props.countries"
                                :key="index"
                                :label="item.country_name"
                                :value="item"
                            ></el-option>
                        </el-select>

                    </div>
                    
                </el-form-item>
            </div>

            <!-- EMAIL AND PHONE -->
            <div class="grid grid-cols-2">

                <!-- EMAIL -->
                <el-form-item
                    prop="email"
                >
                    <div class="flex flex-col grow">

                        <!-- LABEL -->
                        <span
                            v-if="data.showLabel"
                            class="ml-1"
                        >Email</span>

                        <el-input
                            v-model="data.address.email"
                            placeholder="Email"
                            type="text"
                            :maxlength="255"
                            @input="update()"
                            @clear="update()"
                            @change="update()"
                            class="mr-1"
                        />

                    </div>

                </el-form-item>

                <!-- PHONE -->
                <el-form-item
                    prop="phone"
                >

                    <div class="flex flex-col grow">

                        <!-- LABEL -->
                        <span
                            v-if="data.showLabel"
                            class="ml-1"
                        >Phone</span>

                        <el-input
                            v-model="data.address.phone"
                            placeholder="Phone"
                            type="text"
                            :maxlength="255"
                            @input="update()"
                            @clear="update()"
                            @change="update()"
                            class="ml-1"
                        />

                    </div>

                </el-form-item>
            </div>
        </div>

        <!-- ADDITIONAL INFO, 1 FULL ROW -->
        <el-form-item
            prop="address_additional_information"
        >

            <div class="flex flex-col grow">

                <!-- LABEL -->
                <span
                    v-if="data.showLabel"
                    class="ml-1"
                >Additional info</span>

                <el-input
                    v-model="data.address.address_additional_information"
                    placeholder="Additional information"
                    type="text"
                    :maxlength="255"
                    @input="update()"
                    @clear="update()"
                    @change="update()"
                />

            </div>

        </el-form-item>

        <!-- AVIS PHONE, 1 FULL ROW. BELONGS TO ORDER OBJECT NOT THE ADDRESS OBJECT -->
        <!-- //TODO the avis phone might need to belong to addresses, not orders? Because
        one order might have multiple pickup and multiple delivery addresses with avis phones?
        Another solution: avis phone as new object belongst to address? Ask C. For now I will just
        display this here. This topic must be decided when it comes to order editing.-->
        <el-form-item>

            <div class="flex flex-col grow">

                <!-- LABEL -->
                <span
                    v-if="data.showLabel"
                    class="ml-1"
                >Avis phone</span>

                <el-input
                    :model-value="props.avis_phone"
                    placeholder="Avis phone"
                    type="text"
                    :maxlength="255"
                    clearable
                    @input="handleAvisPhone"
                    @clear="handleAvisPhone"
                    @change="handleAvisPhone"
                />

            </div>

        </el-form-item>

        <!--  -->
        <el-form-item>

            <div class="flex flex-col grow">

                <!-- LABEL -->
                <span
                    v-if="data.showLabel"
                    class="ml-1"
                >Comment</span>

                <el-input
                    :model-value="props.comment"
                    placeholder="Comment"
                    type="text"
                    :maxlength="255"
                    @input="handleComment"
                    @clear="handleComment"
                    @change="handleComment"
                />

            </div>

        </el-form-item>
    </div>
</template>

<script setup>
import { ref, reactive, computed, watch, onMounted, onBeforeUnmount } from 'vue';
import addressDummy from '@/Pages/Addresses/CreateEditAddress/addressDummy';//use this in props to have already filled address form for creating new address
import addressEmpty from '@/Pages/Addresses/CreateEditAddress/addressEmpty';//use this in props to have empty address form for creating new address

const props = defineProps({

    address: {
        type: Object,
        required: true,
        /**
         * Returns an empty address object, if the order does not has one.
         */
        default: () => addressDummy,
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
     * The title prop is either 'pickup' or 'delivery'. This is needed for the component 
     * title to render.
     */
    title: String,

    /**
     * The countries prop is an array of all countries. This is needed for the country select
     * to render.
     */
    countries: {
        type: Array,
        required: true,
    },

    /**
     * The avis phone is a burner phone number, that will be used only once, for the given order.
     * IT DOES NOT BELONG TO THE ADDRESS, IT BELONGS TO THE ORDER OBJECT! It is displayed in the
     * address form, because Francesco said so.
     */
    avis_phone: {
        type: String,
        required: false,
    },

    /**
     * This is the special comment or info for the pickup or for the delivery.
     * IT DOES NOT BELONG TO THE ADDRESS, IT BELONGS TO THE ORDER OBJECT! It is displayed in the
     * address form, because Francesco said so.
     */
    comment: {
        type: String,
        required: false,
    },

});

const data = reactive({

    /**
     * The address object comes from props. Usually. But it migh happend that the order does not
     * have a headquarter address, or that the address is missing. In that case we should use the
     * addressEmpty object. For development and testing purposes we can use the addressDummy object.
     */
    address: props.address || addressDummy,
    showLabel: true,
});

const emit = defineEmits(['update:address', 'update:comment', 'update:avis_phone']);

/**
 * Only updates the parent's address object. No triggering of submit or edit. No need for validation.
 * Works with address object
 */
const update = () => {
    emit('update:address', data.addressData);
}

/**
 * Here we automatically catch the new value of the input field. Courtesy of Element Plus. We use this
 * value to update the parent's avis_phone prop. No triggering of submit or edit. All this is done
 * outside of the ordinary address object data handling, because avis_phone is not part of the address
 * object. It is part of the order object.
 */
const handleAvisPhone = (value) => {
    emit('update:avis_phone', value);
}

/**
 * Here we automatically catch the new value of the input field. Courtesy of Element Plus. We use this
 * value to update the parent's comment prop. No triggering of submit or edit. All this is done
 * outside of the ordinary address object data handling, because comment is not part of the address
 * object. It is part of the order object.
 */
const handleComment = (value) => {
    emit('update:comment', value);
}

</script>