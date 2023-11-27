<template>

    <!-- CUSTOMERS SEARCH FIELD -->
    <el-input
        :placeholder="props.placeholder"
        v-model="store.searchTerm"
        clearable
        ref="searchTermRef"
        @clear="getData()"
        @change="getData()"
        @input="getData()"
        @keyup.escape.native="clearSearchTermWithEsc()"
    />

    <!-- SEARCH BUTTON-->
    <el-button
        @click="getData"
        type="primary"
        class="mr-3 mt-3 mb-3"
    >Search</el-button>
    
</template>

<script lang="ts" setup>
import { reactive, ref, computed, watch, onUpdated, onMounted, nextTick } from 'vue';
import { router} from '@inertiajs/vue3';//for sending requests;

const props = defineProps({
    store: Object,
    placeholder: String,
});

const emit = defineEmits(['getData']);

/**
 * When ESC is hit, we want to clear the search term, and get all customers again.
 */
 const clearSearchTermWithEsc = () => {
    props.store.searchTerm = '';
    getData();
};

function getData() {
    emit('getData');
}

//SETTING FOCUS IN INPUT FIELD
let searchTermRef = ref(null);
onMounted(() => {

    /**
     * INPUT FIELD
     * When the page is loaded, we want to focus on the search input.
     * So we use the mounted() lifecycle hook, and we focus on the search input.
     */
    nextTick(() => {
        searchTermRef.value.focus();
    });
});

</script>

<style scoped>
</style>


