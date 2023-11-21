<template>
    <div>

        <!--  -->
        <el-form
            ref="ruleFormRef"
            :model="customer"
            label-position="top"
            :rules="rules"
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

                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="errors.company_name"
                    v-text="errors.company_name"
                    class="text-red-500 text-xs mt-1"
                ></div>
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

                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="errors.name"
                    v-text="errors.name"
                    class="text-red-500 text-xs mt-1"
                ></div>
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

                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="errors.email"
                    v-text="errors.email"
                    class="text-red-500 text-xs mt-1"
                ></div>
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
                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="errors.rating"
                    v-text="errors.rating"
                    class="text-red-500 text-xs mt-1"
                ></div>
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
                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="errors.tax_number"
                    v-text="errors.tax_number"
                    class="text-red-500 text-xs mt-1"
                ></div>
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
                <!-- BACKEND VALIDATION ERROR DISPLAY -->
                <div
                    v-if="errors.internal_cid"
                    v-text="errors.internal_cid"
                    class="text-red-500 text-xs mt-1"
                ></div>
            </el-form-item>

            <!-- BUTTONS -->
            <div class="flex flex-row">
                <el-form-item class="pr-5">
                    <el-button
                        type="primary"
                        @click="submitForm(ruleFormRef)"
                    >Submit</el-button>
                </el-form-item>
    
                <!-- <el-form-item>
                    <el-button
                        type="danger"
                        @click="closePopup"
                    >Cancel</el-button>
                </el-form-item> -->
            </div>
        </el-form>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue';
import type { FormInstance, FormRules } from 'element-plus'
import { router } from '@inertiajs/vue3'

interface RuleForm {
    company_name: string,
    name: string,
    email: string,
    rating: string,
    tax_number: string,
    internal_cid: string,
}

const ruleFormRef = ref<FormInstance>()
const customer = reactive<RuleForm>({
    company_name: '',
    name: '',
    email: '',
    rating: '',
    tax_number: '',
    internal_cid: '',
})

let props = defineProps(
    {
        errors: Object,
    }   
)

const rules = reactive<FormRules<RuleForm>>({
    company_name: [
        { required: true, message: 'Company name is required FE', trigger: 'blur' },
        { min: 3, max: 5, message: 'Length should be 3 to 5', trigger: 'blur' },
    ],
    name: [
            { required: true, message: 'Name is required FE', trigger: 'blur' },
        ],
    email: [
        { required: true, message: 'Email is required FE', trigger: 'blur' },
    ],
    // rating: [
    //     { required: true, message: 'Rating is required FE', trigger: 'blur' },
    // ],
    tax_number: [
        { required: true, message: 'Tax number is required FE', trigger: 'blur' },
    ],
    internal_cid: [
        { required: true, message: 'Internal CID is required FE', trigger: 'blur' },
    ],
})

const submitForm = async (formEl: FormInstance | undefined) => {
    // console.log('submit!', customer)
    // router.post('/customers', customer)
    if (!formEl) return
    await formEl.validate((valid, fields) => {
        if (valid) {
            console.log('submit!', customer)
            router.post('/customers', customer)
        } else {
            console.log('error submit!', fields)
        }
    })
}

const resetForm = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.resetFields()
}



// export default defineComponent({
//     components: {
//     },
//     props: {
//         errors: Object,
//     },
//     data() {
//         return {
//             customer: useForm({
//                 company_name: 'xxx',
//                 name: 'jedan',
//                 email: 'bla@gmail.com',
//                 rating: '5',
//                 tax_number: '5555',
//                 internal_cid: '66666',
//             }),
//             // validationRules: {
//             //     company_name: [
//             //         { required: true, message: 'Company name is required', trigger: 'blur' },
//             //     ],
                
//             // },
//         }
//     },
//     emits: ['closePopup'],
//     methods: {
//         submit(){
//             this.customer.post('/customers');
//             this.closePopup();
//         },

//         // async submit(){
//             // console.log(this.$refs);
//             // console.log('customer:', customer)
//             // if(!customer) return;
//             // await customer.validate((valid, fields) => {
//             //     if (valid) {
//             //         console.log('submit!')
//             //     } else {
//             //         console.log('error submit!', fields)
//             //     }
//             // });
//         // },


//         /**
//          * Close popup and reset customer data.
//          */
//         closePopup(){
//             // this.customer = { 
//             //     company_name: '',
//             //     name: '',
//             //     email: '',
//             //     rating: '',
//             //     tax_number: '',
//             //     internal_cid: '',
//             // };
//             this.$emit('closePopup');
//         }
//     },

// })
</script>

<style scoped>

</style>