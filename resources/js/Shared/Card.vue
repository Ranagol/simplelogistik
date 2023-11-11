<template>
    <div class="component_background p-5 card_border">

        <!-- SLOT -->
        <slot></slot>

    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
export default defineComponent({
    components: {
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

});
</script>

<style scoped>
.card_border {
    border: none;
    border-radius: 8px;
    height: auto;
    height:100%;/*Fills up 100% the space available*/
}
</style>
