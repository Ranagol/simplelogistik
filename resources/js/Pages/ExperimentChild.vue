<template>
    <strong>ExperimentChild</strong>
    <el-input
      v-model="modelValue.name"
    />
    <!-- <el-input v-model="experiment.desciption" /> -->

</template>

<script lang="ts" setup>
import { reactive, computed, watch, onMounted, nextTick } from 'vue';
import { router} from '@inertiajs/vue3';//for sending requests

let props = defineProps(
    {
        modelValue: {
            type: Object,
            required: false,
        },
    }
);

const fullName = computed({
      get() {
        return `${firstName.value} ${lastName.value}`;
      },
      set(value) {
        const [first, last] = value.split(' ');
        firstName.value = first;
        lastName.value = last;
      },
    });



</script>
