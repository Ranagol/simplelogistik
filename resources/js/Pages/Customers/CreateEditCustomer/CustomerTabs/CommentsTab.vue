<template>

    <div class="w-1/2">

        <!-- INPUT FIELD -->
        <el-input
            type="textarea"
            :rows="5"
            placeholder="Add a comment"
            v-model="data.comment"
            minlength="3"
            maxlength="500"
            show-word-limit
        />

        
    </div>

    <!-- BACKEND VALIDATION ERROR DISPLAY -->
    <div
        v-if="props.errors.comments"
        v-text="props.errors.comments"
        class="text-red-500 text-xs mt-1"
    ></div>

    <!-- SUBMIT BUTTON -->
    <el-button
        type="primary"
        @click="submit"
        class="mt-3"
    >Create new comment</el-button>

    <div
        v-if="data.customer.comments"
    >{{ data.customer.comments }}</div>

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
import { router} from '@inertiajs/vue3';//for sending requests;

const props = defineProps({
    customer: {
        type: Object,
        required: true,
    },

    errors: {
        type: Object,
    },
});

watch(
    () => props.customer, 
    customer => data.customer = customer,
    { deep: true }
);

let data = reactive({
    comment: '',
    customer: props.customer,
});

const submit = () => {
    console.log('submit comment creating started');

    router.patch(
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

    console.log('submit comment creating finished');

}


</script>