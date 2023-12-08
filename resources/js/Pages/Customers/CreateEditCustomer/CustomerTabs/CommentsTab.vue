<template>

    <!-- :model="data" we connect the el-form with our place, where we store form data. Thanks to
    this, we can do prop="comment" in the el-form-item. Which is necesary for FE validation. 
    But, in this case, data is also an Inertiajs form helper. Which is necesary and important.-->
    <!-- :rules are the validation rules -->
    <el-form
        ref="elFormRef"
        :model="data"
        :rules="data.rules"
        status-icon
    >
        <!-- Validation will not work without prop="comment" -->
        <el-form-item
            label="Comment"
            prop="comment"
        >
            <!-- INPUT FIELD -->
            <!-- Yes, although el-form is connected to data, prop is connected to data (these are
                needed for validation, we still must do v-model="data.comment". Which is necesary
                for data synchronisation.) -->
            <el-input
                type="textarea"
                :rows="5"
                placeholder="Add a comment"
                v-model="data.comment"
                minlength="3"
                maxlength="500"
                show-word-limit
            />

            <!-- BACKEND VALIDATION ERROR DISPLAY, with the help of the form helper. Remember:
            form helper = data, because const data = useForm({... ... -->
            <div
                v-if="data.errors.comment"
                v-text="data.errors.comment"
                class="text-red-500 text-xs mt-1"
            ></div>
        </el-form-item>

        <el-form-item>

            <!-- SUBMIT BUTTON, also must be in an el-form-item, inside el-form
            And, it must send the elFormRef as a argument. -->
            <el-button
                type="primary"
                @click="submit(elFormRef)"
                class="mt-3"
            >Create new comment</el-button>

        </el-form-item>
    </el-form>


    <!-- TABLE FOR DISPLAYING ALL COMMENTS BELONGING TO THE CLIENT -->
    <el-table
        :data="data.customer.comments"
        class="mt-2"
        width="50%"
    >
        <el-table-column
            prop="date"
            label="Date"
            width="180"
        ></el-table-column>
        <el-table-column
            prop="comment"
            label="Comment"
            width="180"
        ></el-table-column>
        <el-table-column
            prop="user_name"
            label="Created by"
            width="180"
        ></el-table-column>

    </el-table>

</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    customer: {
        type: Object,
        required: true,
    },

});

watch(
    () => props.customer, 
    customer => data.customer = customer,
    { deep: true }
);

//This is necesary for validation, and it must be done with ref(), must not be done with reactive()
const elFormRef = ref(null);

/**
 * remember: here data = form helper. So we do data.patch() instead of form.patch()
 */
const data = useForm({
    comment: '',//this is the actual stuff that we do BE and FE validation. One comment.
    customer: props.customer,

    /**
     * The form fields validation rules.
     * To turn off FE validation for comment, simply comment out the rules for comment.
     */
    rules: {
        comment: [
            { required: true, message: 'Please enter a comment FE', trigger: 'blur' },
            { min: 3, message: 'Comment must be at least 3 characters long', trigger: 'blur' },
            { max: 500, message: 'Comment must be at most 500 characters long', trigger: 'blur' },
        ],
    },
}); 

/**
 * This triggers the FE validation. It is triggered when the user clicks the submit button.
 * 
 */
const submit = async (elFormRef) => {
    if(!elFormRef){
        return
    }
    await elFormRef.validate((valid, fields) => {
        // If the FE validation is ok...
        if (valid) {
            console.log('submit!')
            data.patch(//this data here is actually a form helper, that was named by me as data
                `/customers/${props.customer.id}/comments/create`,
                {
                    comment: data.comment,
                },
                {
                    onSuccess: () => {
                        console.log('success');
                    },
                    onError: () => {
                        console.log('error');
                        ElMessage.error('Oops, something went wrong while creating the comment.')
                        ElMessage(errors);
                    },
                }
            );
        } else {
            //If the FE validation is not ok...
            console.log('error submit!', fields);
            ElMessage.error('Oops, something went wrong while creating the comment.')
            ElMessage(errors);
        }
    })
}

</script>