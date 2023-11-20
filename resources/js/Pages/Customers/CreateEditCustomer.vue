<template>
    <div>

        <!-- :rules="validationRules" -->
        <el-form
            ref="createEditCustomerForm"
            :model="customer"
            
            label-position="top"
        >
            <el-form-item
                label="Company name"
                prop="company_name"
                width="100px"
            >
                <el-input
                    v-model="customer.company_name"
                    placeholder="Company name"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                />
            </el-form-item>

            <el-form-item
                label="Name"
                prop="name"
            >
                <el-input
                    v-model="customer.name"
                    placeholder="Name"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                />
            </el-form-item>

            <el-form-item
                label="Email"
                prop="email"
            >
                <el-input
                    v-model="customer.email"
                    placeholder="Email"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                />
            </el-form-item>

            <el-form-item
                label="Rating"
                prop="rating"
            >
                <el-input
                    v-model="customer.rating"
                    placeholder="Rating"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                />
            </el-form-item>

            <el-form-item
                label="Tax number"
                prop="tax_number"
            >
                <el-input
                    v-model="customer.tax_number"
                    placeholder="Tax number"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                />
            </el-form-item>

            <el-form-item
                label="Internal CID"
                prop="internal_cid"
            >
                <el-input
                    v-model="customer.internal_cid"
                    placeholder="Internal CID"
                    type="text"
                    show-word-limit
                    :maxlength="255"
                />
            </el-form-item>

            <el-form-item>
                <el-button
                    type="primary"
                    @click="submit"
                >Submit</el-button>
            </el-form-item>

            
        </el-form>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useForm } from '@inertiajs/vue3';//0-Importing the form helper
export default defineComponent({
    components: {
    },
    // props: {
    // },
    data() {
        return {
            customer: useForm({
                company_name: '',
                name: '',
                email: '',
                rating: '',
                tax_number: '',
                internal_cid: '',
            }),
            // validationRules: {
            //     company_name: [
            //         { required: true, message: 'Company name is required', trigger: 'blur' },
            //     ],
            //     name: [
            //         { required: true, message: 'Name is required', trigger: 'blur' },
            //     ],
            //     email: [
            //         { required: true, message: 'Email is required', trigger: 'blur' },
            //     ],
            //     // rating: [
            //     //     { required: fla, message: 'Rating is required', trigger: 'blur' },
            //     // ],
            //     tax_number: [
            //         { required: true, message: 'Tax number is required', trigger: 'blur' },
            //     ],
            //     internal_cid: [
            //         { required: true, message: 'Internal CID is required', trigger: 'blur' },
            //     ],
            // },
        }
    },
    computed: {
    },
    methods: {
        submit(){
            this.customer.post('/customers');//2-We use the form object from the data() for sending requests
        }
    },

});
</script>

<style scoped>

</style>