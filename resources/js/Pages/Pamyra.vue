<template>
    <Head title="Pamyra" />

    <Card>
        <h1>Pamyra</h1>


    </Card>


</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Card from '../Shared/Card.vue';
export default defineComponent({
    components: {
        Card
    },
    props: {
    },
    data() {
        return {

        }
    },
    computed: {
    },
    methods: {
    },

    mounted() {

        /**
         * This is the way how to incorporate external JavaScript files into Vue components.
         * 
         * https://stackoverflow.com/questions/45047126/how-to-add-external-js-scripts-to-vuejs-components
         * https://medium.com/@lassiuosukainen/how-to-include-a-script-tag-on-a-vue-component-fe10940af9e8
         */
        let pamyraScript = document.createElement('script')
        pamyraScript.setAttribute('src', 'https://www.pamyra.de/plugin/pamyra4u.js?apikey=IHRAPIKEY')
        document.head.appendChild(pamyraScript)
    },
    


});
</script>

<style scoped>

</style>