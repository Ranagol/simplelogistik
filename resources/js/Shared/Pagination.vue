<template>
    <div>

        <!-- PAGINATION FULL, WITH ALL FEATURES. IT HAS PER PAGE SETTINGS TOO. This is Pagination2.vue
        There are a couple of things, that need explanation here. So, here we go..
        :total="total"                      - see the props.total
        :total-page-count="lastPage"        - see the props.lastPage
        @current-change="pageChange"        - if the user asks for new pagination...
        @size-change="pageSizeChange"       - if the user changes the records per page value
        :current-page.sync="value"          - which page is our current page in the pagination.
        :page-sizes="[5, 10, 15, 20]"       - These are options, how many records could be on one page, offered to the user
        :page-size="pageSize"               - How many records are we displaying currently on one page
        layout="total, sizes, prev, pager, next, jumper"    - Which elements of the el-paginate are we displaying

        -->
        <el-pagination
            :total="total"
            :total-page-count="lastPage"
            @current-change="pageChange"
            @size-change="pageSizeChange"
            :current-page.sync="value"
            :page-sizes="[5, 10, 15, 20]"
            :page-size="pageSize"
            layout="total, sizes, prev, pager, next, jumper"
        ></el-pagination>

    </div>
</template>

<script>
import { defineComponent } from 'vue';
export default defineComponent({
    props: {

        /**
         * we will directly connect this value to the <el-pagination> :current-page. This shows
         * our current page. If we are on page 1, then this value will be ... 1.
         * This data is sent by the awesome Laravel ->paginate()
         */
        value: {
            required: false,
            type: Number,
            default: 1// <---here we set the current page to be 1 by default
        },

        /**
         * Example: if we have 461 clients, displaying by 5 clients per page, we will have 93
         * pages in total. So, the last page will be 93.
         * This data is sent by the awesome Laravel ->paginate()
         *
         */
        lastPage: {
            required: false,
            type: Number,
            default: 0
        },

        /**
         * This is the total number of cases that we work with in the pagination. Example: if
         * we have 461 clients in db total, then the total will be 461.
         * This data is sent by the awesome Laravel ->paginate()
         *
         */
        total: {
            required: false,
            type: Number,
            default: 0
        },

        /**
         * This pageSize means, that we said to Laravel ->paginate(5), aka that we want to see 5 clients
         * on one page. The el-paginate has a page-size
         * This data is sent by the awesome Laravel ->paginate()
         */
        pageSize: {
            required: false,
            type: [Number, String],
            default: 5 // <---here we set the pageSize to be default 5 records per page
        },
    },

    methods: {

        /**
         * If there is any change, any click on the pagination element, we want to trigger this
         * pageChange() function. Now, if there is a change, then we will be moved to another
         * pagination page. Aka, there will be a new currentPage state. This new currentPage
         * will be automatically sent as an argument from the el-pagination component to Laravel
         * ->paginate().
         */
        pageChange (currentPage) {

            /**
             * sending to the parents data()/paginationData.current_page, through v-model.
             * v-model="paginationData.current_page"
             * This way the parent always knows which is our current page.
             * Example: if the user was on page 1, and clicked on page 2 in the pagination,
             * then this currentPage value will be 2.
             */
            this.$emit('input', currentPage);

            /**
             * Here we send a message to the backend: hey the user wants to go to a new pagination
             * page, here is the new currentPage value.
             * Example: if the user was on page 1, and clicked on page 2 in the pagination,
             * then this currentPage value will be 2.
             */
            this.$emit('current-change', currentPage);
        },

        /**
         * Example: by  default, we display 10 records per page. The user can change this to
         * 20, 30, 40... If this happens, this function will be triggered. What it does:
         * 1. sets the per_page value in the parent's paginationData. So per_page is loaded now,
         * and ready for sending to the backend.
         * 2. Triggers the this.pageChange(), which will actually send a new request to Laravel,
         * containing the previously set per_page value.
         */
        pageSizeChange(newPageSize){
            this.$emit('newPageSize', newPageSize);
        }
    },
})
</script>
