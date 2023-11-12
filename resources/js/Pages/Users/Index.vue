<template>
    <Head title="Users" />
    <Card>
        <h1>Users</h1>

        <el-table :data="users" style="width: 100%">
            <el-table-column
                prop="id"
                label="ID"
                width="50"
            ></el-table-column>

            <el-table-column
                prop="name"
                label="Name"
                width="200"
            ></el-table-column>

            <el-table-column
                prop="email"
                label="Email"
                width="220"
            ></el-table-column>

            <el-table-column
                prop="created_at"
                label="Created At"
                width="250"
            ></el-table-column>

            <el-table-column
                prop="updated_at"
                label="Updated At"
                width="250"
            ></el-table-column>
        </el-table>
    </Card>

</template>

<script lang="ts">
import { PropType, defineComponent } from 'vue';
import { User } from '@/types/Models/User';
import Card from '@/Shared/Card.vue';
export default defineComponent({
    components: {
        Card,
    },
    props: {
        users: Array as PropType<User[]>
    },
    data() {
        return {
            //
        };
    },
    methods: {
    },
});

</script>
