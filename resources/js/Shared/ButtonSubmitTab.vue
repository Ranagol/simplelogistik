<template>
    <div class="flex flex-row justify-end">
        <el-button
            type="primary"
            @click="submit"
        >Submit</el-button>
    </div>
</template>

<script setup>

/**
 * This is just a simple button, aligned to right side. It emits a submit event.
 */
const emit = defineEmits(['submit']);
const submit = () => {
    emit('submit');
}
</script>