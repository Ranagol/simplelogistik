<template>
    <Card>
        <div>
            <h1>First Page</h1>
        </div>
        <div>
            <Second />
        </div>

        <!-- TODO how to make background of the input field the desired color? -->
        <el-input v-model="text" :input-style="styleObject" class="experiment"/>

        <el-button  type="primary">Primary</el-button>
    </Card>

</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Second from '@/Pages/Second.vue';
import Card from "@/Shared/Card.vue";

export default defineComponent({
    components: {
        Second,
        Card
    },
    data() {
        return {
            text: 'Hello World' as string,
            styleObject: {
                color: 'lightslategray',
                fontSize: '13px',
                backgroundColor: '#2f3349 !important'
            }
        }
    }
});

</script>

<style scoped>
/*.experiment {
    color: red;
    font-size: 13px;
    background-color: #2f3349 !important;
}

.el-input .el-input__wrapper {
    color: green;
    font-size: 13px;
    background-color: #2f3349 !important;
}*/
</style>
