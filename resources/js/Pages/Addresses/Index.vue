<template>
    <Head title="Addresses" />

    <Card>
        <h1>Addresses</h1>

        <!-- ADDRESS SEARCH FIELD -->
        <el-input
            placeholder="Search addresses..."
            v-model="searchTerm"
            clearable
            ref="searchTerm"
            @clear="getAddresses()"
            @change="getAddresses()"
            @input="handleSearchTermChange()"
            @keyup.escape.native="clearSearchTermWithEsc()"
        />

        <!-- BUTTON -->
        <el-button
            @click="getAddresses"
        >Search</el-button>

        <!-- ADDRESS TABLE -->
        <el-table
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
        </el-table>

        <el-pagination
            v-model:current-page="paginationData.current_page"
            v-model:page-size="paginationData.per_page"
            :total="paginationData.total"
            :page-sizes="[5, 10, 15, 20]"
            layout="total, sizes, prev, pager, next, jumper"
            @size-change="handleItemsPerPageChange"
            @current-change="handleCurrentPageChange"
        />
    </Card>

</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Address } from '@/types/models/Address';
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
        dataFromAddressController: Object,

        /**
         * We need to pass the searchTermProp, sortColumnProp and sortOrderProp from the backend
         * to the frontend. So the backend sends them, and this component receives them as props.
         * However, props data can't be changed. So we need to store them in data().
         */
        searchTermProp: String,
        sortColumnProp: String,
        sortOrderProp: String,
    },
    data() {
        return {
            /**
             * Unfortunatelly, addresses are coming in from backend mixed with pagination data.
             * That is what we have here in the dataFromAddressController. We need
             * seaparted addresses and separated pagination data. This will happen in computed properties.
             */
            addresses: this.dataFromAddressController.data || [] as Address[],

            //search by text
            searchTerm: this.searchTermProp,

            //sort in el-table
            sortOrder: this.sortOrderProp,
            sortColumn: this.sortColumnProp,

            /**
             * All pagination related data is stored here. 
             * Unfortunatelly,addresses are coming in from backend mixed with pagination data.
             * That is what we have here in the dataFromAddressController. We need
             * seaparated addresses and separated pagination data. This will happen in computed properties.
             * Here. So, this is the pagination related data. And a small reminder:
             * 
             * el-pagination        Laravel ->paginate()
             * current-page	        paginationData.current_page         Where the user is currently
             * page-size	        paginationData.per_page             Number of items / page
             * total	            paginationData.total                Number of all db records
             */
            paginationData: _.omit({...this.dataFromAddressController}, 'data') || {},

        };
    },
    methods: {

        /**
         * getAddresses() is triggered by: 
         * 
         * the search button, 
         * the sorting clicks, 
         * the pagination clicks.
         * Also on input field clear/reset.
         * If enter is hit by the user.
         * 
         * It sends a request to the backend to get the addresses. The backend will return the addresses 
         * sorted and the pagination data. getAddresses() does not have arguments, because it uses the
         * data from data(). Because every search/sort/paginate change is in the data().
         */
        getAddresses() {
            this.$inertia.get(
                '/addresses',
                {
                    /**
                     * This is the data that we send to the backend.
                     */
                    searchTerm: this.searchTerm,
                    sortColumn: this.sortColumn,
                    sortOrder:  this.sortOrder,
                    page: this.paginationData.current_page,
                    newItemsPerPage: this.paginationData.per_page
                },
            );
        },

        /**
         * SORTING
         * sort() is activated by the main table header sort arrows. 
         * Problem: el-table returns ascending or descending, however my backend works with 
         * 'asc' or 'desc'. So here we also transform the ascending/descending to asc/desc.
         */
        sort({ prop, order }: {prop: string, order: string }): void {

            //Setting the sort order in data()
            if (order === 'descending') {
                this.sortOrder = 'desc';
            } else {
                this.sortOrder = 'asc';
            }
            //Setting sortColumn ind data()
            this.sortColumn = prop;
            this.getAddresses();
        },

        /**
         * PAGINATION 1
         * Example: by  default, we display 10 records per page. The user can change this to
         * 20, 30, 40... If the user for example changes the 10 to 20 records per page, then this
         * function will be triggered.
         * We set the this.paginationData.per_page to the new value.
         */
        handleItemsPerPageChange(newItemsPerPage: number): void{
            // console.log('newItemsPerPage:', newItemsPerPage)
            this.paginationData.per_page = newItemsPerPage;
            // console.log('this.paginationData.per_page:', this.paginationData.per_page)
            this.getAddresses();
        },

        /**
         * PAGINATION 2
         * If there is any change, any click on the pagination element, we want to trigger this
         * pageChange() function. Now, if there is a change, then we will be moved to another
         * pagination page. Aka, there will be a new currentPage state. This new currentPage
         * will be automatically sent as an argument from the el-pagination component to Laravel
         * ->paginate().
         */
        handleCurrentPageChange(newCurrentPage: number){
            this.paginationData.current_page = newCurrentPage;
            this.getAddresses();
        },

        /**
         * INPUT FIELD
         * For every typed letter in the input field, this function will get the filtered addresses,
         * again and again.
         * This is how we can throttle this function: 
         * https://www.geeksforgeeks.org/lodash-_-throttle-method/
         */
        handleSearchTermChange(){
            // console.log('handleSearchTermChange()');
            this.getAddresses();
        },

        /**
         * INPUT FIELD
         * When ESC is hit, we want to clear the search term, and get all addresses again.
         */
        clearSearchTermWithEsc(){
            this.searchTerm = '';
            this.getAddresses();
        },
    },
    mounted() {

        /**
         * INPUT FIELD
         * When the page is loaded, we want to focus on the search input.
         * So we use the mounted() lifecycle hook, and we focus on the search input.
         */
        this.$nextTick(() => {
            this.$refs.searchTerm.focus();
        });
    },
});

</script>
