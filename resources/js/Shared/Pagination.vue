<template>
    <el-pagination
        :current-page="props.paginationData.current_page"
        :page-size="props.paginationData.per_page"
        :total="props.paginationData.total"
        :page-sizes="[5, 10, 15, 20]"
        layout="total, sizes, prev, pager, next, jumper"
        @size-change="handleItemsPerPageChange"
        @current-change="handleCurrentPageChange"
    />
    
</template>

<script setup>
import { reactive } from 'vue';

const emit = defineEmits(['getData', 'update:paginationData']);

const props = defineProps({
    paginationData: Object,
});

/**
 * In this case we must have the paginationData in data() to. paginationData has a specific object
 * structure, needed for Laravel. So here, we just change some specific valus in the paginationData,
 * and then we send the whole object back to parent index.vue.
 */
let data = reactive({
    paginationData: props.paginationData,
});

/**
 * PAGINATION 1
 * Example: by  default, we display 10 records per page. The user can change this to
 * 20, 30, 40... If the user for example changes the 10 to 20 records per page, then this
 * function will be triggered.
 * We set the this.paginationData.per_page to the new value.
 */
 const handleItemsPerPageChange = (newItemsPerPage) => {
    data.paginationData.per_page = newItemsPerPage;
    emit('update:paginationData', data.paginationData);//we update the paginationData in parent index.vue
    emit('getData');//we send a signal to index.vue that he needs to get new data, with the new paginationData
};

/**
 * PAGINATION 2
 * If there is any change, any click on the pagination element, we want to trigger this
 * pageChange() function. Now, if there is a change, then we will be moved to another
 * pagination page. Aka, there will be a new currentPage state. This new currentPage
 * will be automatically sent as an argument from the el-pagination component to Laravel
 * ->paginate().
 */
 const handleCurrentPageChange = (newCurrentPage) => {
    data.paginationData.current_page = newCurrentPage;
    emit('update:paginationData', data.paginationData);
    emit('getData');
};


</script>

<style scoped>
</style>
