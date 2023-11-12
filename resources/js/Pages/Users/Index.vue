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
        <el-button
            @click="getUsers"
        >Search</el-button>

        <!-- USERS TABLE -->
        <el-table :data="users" style="width: 100%">
            <el-table-column
                prop="id"
                label="ID"
                width="50"
            ></el-table-column>

            <el-table-column
                prop="name"
                label="Name"
            ></el-table-column>

            <el-table-column
                prop="email"
                label="Email"
            ></el-table-column>

            <el-table-column
                prop="created_at"
                label="Created At"
            ></el-table-column>

            <el-table-column
                prop="updated_at"
                label="Updated At"
            ></el-table-column>

        </el-table>

        <!-- PAGINATION -->
        <el-pagination
            :page-size="10"
            :pager-count="11"
            layout="prev, pager, next"
            :total="1000"
        />
    </Card>

</template>

<script lang="ts">
import { PropType, defineComponent } from 'vue';
import { User } from '@/types/Models/User';
import Card from '@/Shared/Card.vue';
import _ from 'lodash';
export default defineComponent({
    components: {
        Card,
    },
    props: {
        // users: Array as PropType<User[]>
        /**
         * Unfortunatelly,users are coming in from backend mixed with pagination data.
         * That is what we have here in the dataFromUserController. We need
         * seaparted users and separated pagination data. This will happen in computed properties.
         */
        dataFromUserController: Object
    },
    data() {
        return {
            searchTerm: '',
            // users: this.dataFromUserController.data || [],
            // paginationData: {},
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
        getUsers() {
            this.$inertia.get(
                '/users',
                { searchTerm: this.searchTerm},//here we send our search term to the backend
                {
                    // preserveState: true,//to remember search term
                    // replace: true//something about history records... Not important
                }
            );
        }
    },
});

</script>
