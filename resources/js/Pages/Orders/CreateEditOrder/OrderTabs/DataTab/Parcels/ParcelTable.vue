<template>
    <el-table
        :data="data.parcels"
        style="width: 100%"
        ref="tableRef"
        stripe
        highlight-current-row
        empty-text="No result. Try with different search parameters."
    >
        <el-table-column
            label="ID"
            prop="id"
            width="100"
        ></el-table-column>

        <el-table-column
            label="Packaging"
            prop="p_name"
            width="300"
        ></el-table-column>

        <el-table-column
            label="Content"
            prop="information"
            width="600"
        ></el-table-column>

        <el-table-column
            label="Length cm"
            prop="p_length"
            width="100"
        ></el-table-column>

        <el-table-column
            label="Width cm"
            prop="p_width"
            width="100"
        ></el-table-column>

        <el-table-column
            label="Height cm"
            prop="p_height"
            width="100"
        ></el-table-column>

        <el-table-column
            label="Weight kg"
            prop="p_weight"
            width="100"
        ></el-table-column>

    </el-table>

</template>

<script setup>
import { reactive, computed, watch, onMounted, ref, onUpdated, nextTick } from 'vue';

const props = defineProps({
    parcels: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
    mode: {
        type: String,
        required: true,
    },
});

const data = reactive({
    parcels: props.parcels,
});
</script>