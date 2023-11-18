<template>
    <Head title="Users" />
    <Card>
        <h1>Users</h1>

        <!-- USERS SEARCH FIELD -->
        <el-input
            placeholder="Search users..."
            prefix-icon="el-icon-search"
            v-model="searchTerm"
            clearable
        ></el-input>

        <!-- BUTTON -->
        <el-button
            @click="getUsers"
        >Search</el-button>

        <!-- USERS TABLE -->
        <el-table
            :data="users"
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
                prop="name"
                label="Name"
                sortable="custom"
            ></el-table-column>

            <el-table-column
                prop="email"
                label="Email"
                sortable="custom"
            ></el-table-column>

            <el-table-column
                prop="created_at"
                label="Created At"
                sortable="custom"
            ></el-table-column>

            <el-table-column
                prop="updated_at"
                label="Updated At"
                sortable="custom"
            ></el-table-column>

        </el-table>

        <el-pagination
            v-model:current-page="paginationData.current_page"
            v-model:page-size="paginationData.per_page"
            :total="paginationData.total"
            :page-sizes="[5, 10, 15, 20]"
            layout="total, sizes, prev, pager, next, jumper"
            @size-change="handleItemsPerPageChange"
            @current-change="handleCurrentPageChange"
        ></el-pagination>
    </Card>

</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { User } from '@/types/Models/User';
import Card from '@/Shared/Card.vue';
import Pagination from '@/Shared/Pagination.vue';
import _ from 'lodash';
export default defineComponent({
    components: {
        Card,
        Pagination,
        // layout: Layout,
    },
    props: {        
        dataFromUserController: Object,

        /**
         * We need to pass the searchTermProp, sortColumnProp and sortOrderProp from the backend
         * to the frontend. We do this by passing them as props.
         */
        searchTermProp: String,
        sortColumnProp: String,
        sortOrderProp: String,
        pageProp: String,
        newPageSizeProp: Number,
    },
    data() {
        return {
            /**
             * Unfortunatelly,users are coming in from backend mixed with pagination data.
             * That is what we have here in the dataFromUserController. We need
             * seaparted users and separated pagination data. This will happen in computed properties.
             */
            users: this.dataFromUserController.data || [],

            //search by text
            searchTerm: this.searchTermProp,

            //sort in el-table
            sortOrder: this.sortOrderProp,
            sortColumn: this.sortColumnProp,

            /**
             * All pagination related data is stored here. 
             * Unfortunatelly,users are coming in from backend mixed with pagination data.
             * That is what we have here in the dataFromUserController. We need
             * seaparated users and separated pagination data. This will happen in computed properties.
             * Here. So, this is the pagination related data. And a small reminder:
             * 
             * el-pagination        Laravel ->paginate()
             * current-page	        paginationData.current_page         Where the user is currently
             * page-size	        paginationData.per_page             Number of items / page
             * total	            paginationData.total                Number of all db records
             */
            paginationData: _.omit({...this.dataFromUserController}, 'data') || {},

        };
    },
    methods: {

        /**
         * getUsers() is triggered by: the search button, the sorting clicks, the pagination clicks.
         * It sends a request to the backend to
         * get the users. The backend will return the users sorted and the pagination data.
         */
        getUsers() {
            console.log('getUsers() is activated');
            this.$inertia.get(
                '/users',
                {
                    /**
                     * This is the data that we send to the backend.
                     */
                    searchTerm: this.searchTerm,
                    sortColumn: this.sortColumn,
                    sortOrder:  this.sortOrder,
                    page: this.paginationData.current_page,
                    newPageSize: this.paginationData.per_page
                },
                // {
                    // preserveState: true,//to remember search term
                    // replace: true//something about history records... Not important
                // }
            );
        },

        /**
         * sort() is activated by the main table header sort arrows. 
         * Problem: el-table returns ascending or descending, however my backend works with 
         * 'asc' or 'desc'. So here we also transform the ascending/descending to asc/desc.
         */
        sort({ prop, order }) {
            console.log('sort() is activated');
            console.log('prop:', prop)
            console.log('order:', order)
            //Setting the sort order in data()
            if (order === 'descending') {
                this.sortOrder = 'desc';
            } else {
                this.sortOrder = 'asc';
            }
            //Setting sortColumn ind data()
            this.sortColumn = prop;

            this.getUsers();
        },

        /**
         * PAGINATION
         * Example: by  default, we display 10 records per page. The user can change this to
         * 20, 30, 40... If the user for example changes the 10 to 20 records per page, then this
         * function will be triggered.
         * We set the this.paginationData.per_page to the new value.
         */
        handleItemsPerPageChange(newItemsPerPage: number){
            console.log(`${newItemsPerPage} items per page`)
            this.paginationData.per_page = newItemsPerPage;
            this.getUsers();
        },

        /**
         * PAGINATION
         * If there is any change, any click on the pagination element, we want to trigger this
         * pageChange() function. Now, if there is a change, then we will be moved to another
         * pagination page. Aka, there will be a new currentPage state. This new currentPage
         * will be automatically sent as an argument from the el-pagination component to Laravel
         * ->paginate().
         */
        handleCurrentPageChange(newCurrentPage: number){
            console.log(`current page: ${newCurrentPage}`);
            this.paginationData.current_page = newCurrentPage;
            this.getUsers();
        }
    },
});

</script>
