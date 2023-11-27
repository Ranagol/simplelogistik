<template>

    <div class="flex flex-row">

        <!-- CUSTOMERS SEARCH FIELD -->
        <el-input
            :placeholder="props.placeholder"
            v-model="store.searchTerm"
            clearable
            style="width: 50%"
            ref="searchTermRef"
            @clear="getData()"
            @change="getData()"
            @input="getData()"
            class="mt-1"
            @keyup.escape.native="clearSearchTermWithEsc()"
        />
    
        <!-- SEARCH BUTTON-->
        <el-button
            @click="getData"
            type="primary"
            class="ml-3 mt-1"
        >Search</el-button>

        <!-- CREATE NEW CUSTOMER BUTTON -->
        <el-button
            @click="handleCreate"
            type="info"
            class="ml-3 mt-1"
        >{{ props.createButtonText }}</el-button>
        
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref, computed, watch, onUpdated, onMounted, nextTick } from 'vue';

const props = defineProps({
    store: Object,
    placeholder: String,
    createButtonText: String,
});

const emit = defineEmits(['getData', 'handleCreate']);

/**
 * When ESC is hit, we want to clear the search term, and get all customers again.
 */
 const clearSearchTermWithEsc = () => {
    props.store.searchTerm = '';
    getData();
};

const getData = () => {
    emit('getData');
}

const handleCreate = () => {
    emit('handleCreate');
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


