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
                width="50"
                sortable
            ></el-table-column>

            <el-table-column
                prop="name"
                label="Name"
                sortable
            ></el-table-column>

            <el-table-column
                prop="email"
                label="Email"
                sortable
            ></el-table-column>

            <el-table-column
                prop="created_at"
                label="Created At"
                sortable
            ></el-table-column>

            <el-table-column
                prop="updated_at"
                label="Updated At"
                sortable
            ></el-table-column>

        </el-table>

        <!-- PAGINATION -->
        <Pagination
            v-model="paginationData.current_page"
            :total="paginationData.total"
            :last-page="paginationData.last_page"
            :page-size="paginationData.per_page"
            @newPageSize="setNewPageSize"
            @current-change="getUsers()"
        />
    </Card>

</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { User } from '@/types/Models/User';
import Card from '@/Shared/Card.vue';
import Pagination from '@/Shared/Pagination.vue';
import _ from 'lodash';
import Layout from '@/Shared/Layout.vue';
export default defineComponent({
    components: {
        Card,
        Pagination,
        // layout: Layout,
    },
    props: {
        // users: Array as PropType<User[]>
        /**
         * Unfortunatelly,users are coming in from backend mixed with pagination data.
         * That is what we have here in the dataFromUserController. We need
         * seaparted users and separated pagination data. This will happen in computed properties.
         */
        dataFromUserController: Object,
        searchTermProp: String,
        // sortByThisProp: String,
        // sortOrderProp: String
    },
    data() {
        return {
            searchTerm: this.filters,
            sortOrder: this.sortOrderProp || 'asc',
            sortColumn: this.sortByThisProp || 'id'
        };
    },
    computed: {
        users(): User[] {
            return this.dataFromUserController.data || [];
        },
        paginationData() {
            let paginationData = {...this.dataFromUserController};
            paginationData = _.omit(paginationData, 'data');
            return paginationData || {};
        }
    },
    methods: {

        /**
         * getUsers() is triggered by the search button. It sends a request to the backend to
         * get the users. The backend will return the users and the pagination data.
         */
        getUsers() {
            this.$inertia.get(
                '/users',
                {
                    searchTerm: this.searchTerm,//here we send our search term to the backend
                    sortColumn: this.sortColumn,
                    sortOrder:  this.sortOrder
                },
                {
                    preserveState: true,//to remember search term
                    replace: true//something about history records... Not important
                }
            );
        },

        /**
         * sort() is activated by the main table header sort arrows. This is a request to get the
         * clients again from the db in a new sort order. It seems to me that el-table returns
         * ascending or descending, however my backend works with 'asc' or 'desc'. So here we
         * transform the ascending/descending to asc/desc.
         */
        sort({ prop, order }) {
            console.log('prop:', prop)
            console.log('order:', order)
            //Setting the sort order
            if (order === 'descending') {
                this.sortOrder = 'desc';
            }
            //Setting sortColumn
            this.sortColumn = prop;

            this.getUsers();
        },

        /**
         * Example: by  default, we display 10 records per page. The user can change this to
         * 20, 30, 40... If the user for example changes the 10 to 20 records per page, then this
         * function will be triggered.
         * We set the this.paginationData.per_page to the new value.
         */
         setNewPageSize(newPageSize) {
            this.$set(this.paginationData, "per_page", newPageSize);
            console.log(
                "this.paginationData.per_page NEW VALUE*****",
                this.paginationData.per_page
            );
        },

    },
});

</script>
