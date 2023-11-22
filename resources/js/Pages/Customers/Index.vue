<template>
    <Head title="Customers" />

    <Card>
        <h1>Customers</h1>

        <!-- CUSTOMERS SEARCH FIELD -->
        <el-input
            placeholder="Search customers..."
            v-model="searchTerm"
            clearable
            ref="searchTerm"
            @clear="getCustomers()"
            @change="getCustomers()"
            @input="handleSearchTermChange()"
            @keyup.escape.native="clearSearchTermWithEsc()"
        />

        <!-- BUTTON SEARCH -->
        <el-button
            @click="getCustomers"
        >Search</el-button>

        <!-- CREATE NEW CUSTOMER POPUP -->
        <Popup
            :errors="errors"
            v-model="elDialogVisible"
            :selectedCustomer="selectedCustomer"
            :mode="mode"
        ></Popup>

        <el-button
            @click="handleCreate"
        >Create new customer</el-button>


        <!-- CUSTOMERS TABLE -->
        <el-table
            :data="customers"
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
                prop="company_name"
                label="Company name"
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
                prop="rating"
                label="Rating"
                sortable="custom"
            ></el-table-column>

            <el-table-column
                prop="tax_number"
                label="Tax number"
                sortable="custom"
            ></el-table-column>

            <!-- SHOW/EDIT/DELETE BUTTON -->
            <el-table-column
                label="Show/Edit/Delete"
            >
                <!-- scope.$index = number of the row in table -->
                <!-- scope.row = the object in the cell -->
                <template #default="scope">

                    <el-button
                        size="small"
                        type="info"
                        @click="handleShow(scope.$index, scope.row)"
                    >Show</el-button>

                    <el-button
                        size="small"
                        type="warning"
                        @click="handleEdit(scope.$index, scope.row)"
                    >Edit</el-button>

                    <el-button
                        size="small"
                        type="danger"
                        @click="handleDelete(scope.$index, scope.row)"
                    >Delete</el-button>
                </template>
            </el-table-column>


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
import { Customer } from '@/types/models/Customer';
import Card from '@/Shared/Card.vue';
import Pagination from '@/Shared/Pagination.vue';
import _ from 'lodash';
import Popup from '@/Shared/Popup.vue';
import { router } from '@inertiajs/vue3'

// import { Inertia } from '@inertiajs/inertia'
// import { Inertia } from '@inertiajs/inertia-vue3'
export default defineComponent({
    components: {
        Card,
        Pagination,
        // layout: Layout,
        Popup,
    },
    props: {
        elDialogVisibleProp: Boolean,
        errors: Object, 
        dataFromCustomerController: Object,

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
            mode:'',
            selectedCustomer: {},
            elDialogVisible: false,

            /**
             * Unfortunatelly, customers are coming in from backend mixed with pagination data.
             * That is what we have here in the dataFromCustomerController. We need
             * seaparted customers and separated pagination data. This will happen in computed properties.
             */
            customers: this.dataFromCustomerController.data || [] as Customer[],//TODO why is this erroring TS?

            //search by text
            searchTerm: this.searchTermProp,

            //sort in el-table
            sortOrder: this.sortOrderProp,
            sortColumn: this.sortColumnProp,

            /**
             * All pagination related data is stored here. 
             * Unfortunatelly,customers are coming in from backend mixed with pagination data.
             * That is what we have here in the dataFromCustomerController. We need
             * seaparated customers and separated pagination data. This will happen in computed properties.
             * Here. So, this is the pagination related data. And a small reminder:
             * 
             * el-pagination        Laravel ->paginate()
             * current-page	        paginationData.current_page         Where the user is currently
             * page-size	        paginationData.per_page             Number of items / page
             * total	            paginationData.total                Number of all db records
             */
            paginationData: _.omit({...this.dataFromCustomerController}, 'data') || {},

        };
    },
    methods: {

        /**
         * getCustomers() is triggered by: 
         * 
         * the search button, 
         * the sorting clicks, 
         * the pagination clicks.
         * Also on input field clear/reset.
         * If enter is hit by the user.
         * 
         * It sends a request to the backend to get the customers. The backend will return the customers 
         * sorted and the pagination data. getCustomers() does not have arguments, because it uses the
         * data from data(). Because every search/sort/paginate change is in the data().
         */
        getCustomers() {
            this.$inertia.get(
                '/customers',
                {
                    /**
                     * This is the data that we send to the backend.
                     */
                    searchTerm: this.searchTerm,
                    sortColumn: this.sortColumn,
                    sortOrder:  this.sortOrder,
                    page: this.paginationData.current_page,
                    newItemsPerPage: this.paginationData.per_page,
                    elDialogVisible: this.elDialogVisible,
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
            this.getCustomers();
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
            this.getCustomers();
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
            this.getCustomers();
        },

        /**
         * INPUT FIELD
         * For every typed letter in the input field, this function will get the filtered customers,
         * again and again.
         * This is how we can throttle this function: 
         * https://www.geeksforgeeks.org/lodash-_-throttle-method/
         */
        handleSearchTermChange(){
            // console.log('handleSearchTermChange()');
            this.getCustomers();
        },

        /**
         * INPUT FIELD
         * When ESC is hit, we want to clear the search term, and get all customers again.
         */
        clearSearchTermWithEsc(){
            this.searchTerm = '';
            this.getCustomers();
        },

        handleCreate(){
            console.log('handleCreate()');
            this.elDialogVisible = true;
            this.mode = 'create';
            console.log(' Index elDialogVisible: ', this.elDialogVisible)
        },

        handleShow(index, object) {
            console.log('handleShow()');
            console.log('index:', index);
            console.log('object:', object);
            this.elDialogVisible = true;
            this.mode = 'show';
            this.selectedCustomer = object;
            console.log(' Index elDialogVisible: ', this.elDialogVisible)

        },

        handleEdit(index, object) {
            console.log('handleEdit()');
            console.log('index:', index);
            console.log('object:', object);
            this.mode = 'edit';
            this.elDialogVisible = true;
            this.selectedCustomer = object;
            console.log(' Index elDialogVisible: ', this.elDialogVisible)

        },

        handleDelete(index, object) {
            console.log('index:', index);
            console.log('object:', object);
            router.post('/delete-customer', {
                searchTerm: this.searchTerm,
                sortColumn: this.sortColumn,
                sortOrder:  this.sortOrder,
                page: this.paginationData.current_page,
                newItemsPerPage: this.paginationData.per_page,
                id: object.id,
            })
        }
        
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
