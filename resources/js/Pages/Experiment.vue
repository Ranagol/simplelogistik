<template>
    <Card>
        <Head title="Exp." />
        <strong>Experiment</strong>

        <!-- INPUT -->
        <el-input v-model="experiment.name" />
        <!-- <el-input v-model="experiment.desciption" /> -->

        

        
        <br>
        <ExperimentChild
            v-model="experiment.name"
        />

        <hr>
        <!-- EXPERIMENTS LIST -->
        <!-- <p 
            v-for="experiment in experiments" 
            :key="experiment.name"
        >{{ experiment }}</p> -->

        <!-- <div
            v-if="errors.name"
            v-text="errors.name"
            class="text-red-500 text-xs mt-1"
        ></div> -->
        

        <el-button
            type="primary"
            @click="submit"
        >Create</el-button>
    </Card>
</template>

<script lang="ts" setup>
import { reactive, computed, watch, ref } from 'vue';
import Card from '@/Shared/Card.vue';
import { router} from '@inertiajs/vue3'
import ExperimentChild from '@/Pages/ExperimentChild.vue';

let props = defineProps(
    {
        experiments: {
            type: Object,
            required: false,
        },
        experiment: {
            type: Object,
            required: false,
        },
        errors: {
            type: Object,
            required: false,
        },
    }
);


let experiment = reactive({
    name:'Random name',
    desciption: 'Random description',
})

const submit =  () => {
    router.post(
        '/experiments',
        experiment, 
        {
            /**
             * Will be triggered if no validation error, and if the el-dialog is STILL open.
             */
            onSuccess: () => {
                console.log('onSuccess triggered');
                alert('onSuccess triggered');
                console.log('props errors', props.errors);
            },

            /**
             * Will be triggered if validation error, and if the el-dialog is STILL open.
             */
            onError: () => {
                console.log('onError');
                alert('onError triggered');
                console.log('props errors', props.errors);
            },
        }
    )
}




</script>

<style scoped>
</style>