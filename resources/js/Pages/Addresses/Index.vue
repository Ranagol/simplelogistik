<template>
    <Head title="Addresses" />

    <Card>
        <h1>Addresses</h1>

        <!-- ADDRESS SEARCH FIELD -->
        <!-- <el-input
            placeholder="Search addresses..."
            v-model="searchTerm"
            clearable
            ref="searchTerm"
            @clear="getAddresses()"
            @change="getAddresses()"
            @input="handleSearchTermChange()"
            @keyup.escape.native="clearSearchTermWithEsc()"
        /> -->

        <!-- BUTTON -->
        <!-- <el-button
            @click="getAddresses"
        >Search</el-button> -->

        <!-- ADDRESS TABLE -->
        <!-- <el-table
            :data="addresses"
            style="width: 100%"
            @sort-change="sort"
        >
            <el-table-column
                prop="id"
                label="ID"
                width="80"
                sortable="custom"
            ></el-table-column>

            <el-table-column
                prop="first_name"
                label="First name"
                sortable="custom"
            ></el-table-column>

            <el-table-column
                prop="last_name"
                label="Last name"
                sortable="custom"
            ></el-table-column>

            <el-table-column
                prop="street"
                label="Street"
                sortable="custom"
            ></el-table-column>

            <el-table-column
                prop="house_number"
                label="House number"
                sortable="custom"
            ></el-table-column>

            <el-table-column
                prop="zipcode"
                label="Zipcode"
                sortable="custom"
            ></el-table-column>
        </el-table> -->

        <!-- <el-pagination
            v-model:current-page="paginationData.current_page"
            v-model:page-size="paginationData.per_page"
            :total="paginationData.total"
            :page-sizes="[5, 10, 15, 20]"
            layout="total, sizes, prev, pager, next, jumper"
            @size-change="handleItemsPerPageChange"
            @current-change="handleCurrentPageChange"
        /> -->
    </Card>

</template>


<script>

</script>

