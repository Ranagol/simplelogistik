<template>

    <el-input
        type="textarea"
        :rows="5"
        placeholder="Add a comment"
        v-model="data.comment"
        minlength="3"
        maxlength="500"
        show-word-limit
    />

    <!-- BACKEND VALIDATION ERROR DISPLAY -->
    <div
        v-if="props.errors.comments"
        v-text="props.errors.comments"
        class="text-red-500 text-xs mt-1"
    ></div>

    <el-button
        type="primary"
        @click="submit"
        class="mt-3"
    >Create comment</el-button>

    <div
        v-if="props.customer.comments"
    >{{ customer.comments }}</div>
    


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

let data = reactive({
    comment: '',
});

const submit = () => {
    console.log('submit comment creating started');

    router.patch(
        `/customers/${props.customer.id}/comments/create`,
        // "/customers",
        {
            comment: data.comment,
        },
        {
            onSuccess: () => {
                console.log('success');
                data.comment = '';
            },
            onError: () => {
                console.log('error');
            },
        }
    );

    console.log('submit comment creating finished');
}


</script>