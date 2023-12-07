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

    <el-button
        type="primary"
        @click="submit"
        class="mt-3"
    >Create comment</el-button>

    <!-- {{ customer.comments }} -->


</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import { router} from '@inertiajs/vue3';//for sending requests;

const props = defineProps({
    customer: {
        type: Object,
        required: true,
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
        data.comment,
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