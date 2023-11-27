<template>
    <Head title="Pamyra" />

    <Card>
        <h1>Pamyra</h1>

        <!-- PAMYRA PLUGIN FOR CALCULATING TRANSPORT PRICES -->
        <pamyra-4u></pamyra-4u>

        <!-- PAMYRA LOGIN AREA -->
        <pamyra-manager-plugin></pamyra-manager-plugin>


    </Card>
</template>

<script lang="ts" setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';
import { router } from '@inertiajs/vue3';//for sending requests;
import Card from '../Shared/Card.vue';

let data = reactive({
    apiKey: 'GTbZ23c2AIRoY3EmQWDNU8fXPvsOP6X9',
});



onMounted(() => {
    console.log('onMounted.')
    addPamyraCalculator();
    addPamyraLoginArea();
});

const addPamyraCalculator = () => {
    console.log('addPamyraCalculator()');


    /**
     * This is the way how to incorporate external JavaScript files into Vue components.
     * 
     * https://stackoverflow.com/questions/45047126/how-to-add-external-js-scripts-to-vuejs-components
     * https://medium.com/@lassiuosukainen/how-to-include-a-script-tag-on-a-vue-component-fe10940af9e8
     * 
     * As a result, the JavaScript file at 
     * https://www.pamyra.de/plugin/pamyra4u.js?apikey=${data.apiKey} will be loaded and executed.
     * 
     * Here you can take a look at the behavior of the shipping cost calculator. You can also log in 
     * to the customer area with the access data demo@pamyra.de and the password pamyra4you.
     * 
     * How to configure the look of thie plugin: https://www.pamyra.de/academy/onboarding/website-plugin
     * 
     * How to install Pamyra plugins: https://www.pamyra.de/academy/pamyra4you-auf-meiner-website-installieren
     * 
     * JSON structure of the response: https://www.pamyra.de/academy/tms-schnittstellen
     * 
     *  
     */
    let pamyraCalculatorScript = document.createElement('script');//creates a new <script> element and assigns it to the variable pamyraCalculatorScript.
    pamyraCalculatorScript.setAttribute(//sets the attributes of the <script> element.
        'src', 
        `https://www.pamyra.de/plugin/pamyra4u.js?apikey=${data.apiKey}`
    );
    document.head.appendChild(pamyraCalculatorScript);//adds the pamyraScript element
}

const addPamyraLoginArea = () => {
    console.log('addPamyraLoginArea()');

    let pamyraLoginScript = document.createElement('script');
    pamyraLoginScript.setAttribute(
        'src', 
        `https://www.pamyra.de/plugin-manager/manager-plugin.js?apikey=${data.apiKey}`
    );
    document.head.appendChild(pamyraLoginScript);
}

</script>

<style scoped></style>
