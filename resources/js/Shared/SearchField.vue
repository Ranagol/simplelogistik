<template>
    <div class="flex flex-row">

        <!-- CUSTOMERS SEARCH FIELD -->
        <!-- I use here model-value to tell el-input what is the current search term
        . When there is a change, the new value will be automatically sent from el-input.
        This is received in getData(). See where I defined getData(value). This value is this
        new search term. -->
        <el-input
            :placeholder="props.placeholder"
            :model-value="props.searchTerm"
            clearable
            style="width: 50%"
            ref="searchTermRef"
            @clear="getData"
            @change="getData"
            @input="getData"
            class="mt-1"
            @keyup.escape.native="clearSearchTermWithEsc()"
        />
    
        <!-- SEARCH BUTTON-->
        <el-button
            @click="getData"
            type="primary"
            class="ml-3 mt-1"
        >Search</el-button>
        
    </div>
</template>

<script setup>
import { reactive, ref, computed, watch, onUpdated, onMounted, nextTick } from 'vue';

const props = defineProps({
    searchTerm: String,
    placeholder: String,
    createButtonText: String,
});

const emit = defineEmits(['getData', 'update:searchTerm']);

/**
 * When ESC is hit, we want to clear the search term, and get all customers again.
 */
 const clearSearchTermWithEsc = () => {
    emit('update:searchTerm', '');
    getData();
};

//We request data from the parent component. 
const getData = (value) => {
    console.log('value:', value)
    emit('update:searchTerm', value);
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


