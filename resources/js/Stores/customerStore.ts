import { defineStore } from 'pinia';
import { router } from '@inertiajs/vue3'
import { ElMessage } from 'element-plus';


export const useCustomerStore = defineStore(
    'customer', {

    state: () => ({
        customers: [],
        selectedCustomer: {},
        mode: '',
        elDialogVisible: false,
        errors: {},
        title: '',
        searchTerm: '',
        sortColumn: '',
        sortOrder: '',
        page: '',
        newItemsPerPage: '',
        paginationData: {},

    }),

    getters: {//like computed properties. Use state here.
        customersGetter(state) {
            return state.customers;
        },

        selectedCustomerGetter(state) {
            return state.selectedCustomer;
        },

        modeGetter(state) {
            return state.mode;
        },

        elDialogVisibleGetter(state) {
            return state.elDialogVisible;
        },
    },

    actions: {//like methods. Use .this here

        getCustomersFromDb() {
            this.customers = router.get(
                '/customers',
                {
                    /**
                     * This is the data that we send to the backend.
                     */
                    searchTerm: this.searchTerm,
                    sortColumn: this.sortColumn,
                    sortOrder: this.sortOrder,
                    page: this.page,
                    newItemsPerPage: this.newItemsPerPage,
                    elDialogVisible: this.elDialogVisible
                }
            );
        },

        deleteCustomer(customer) {
            this.customers = this.customers.filter((item) => item.id !== customer.id);
            router.delete(
                `/customers/${customer.id}`,
                {
                    onSuccess: () => {
                        ElMessage({
                            message: 'Customer deleted successfully',
                            type: 'success',
                        });
                        this.getCustomersFromDb();
                    },
                    onError: (errors) => {
                        ElMessage.error('Oops, something went wrong while creating a new customer.')
                        ElMessage(errors);
                    }
                }
            )
        },

        createCustomer() {
            router.post(
                '/customers', 
                this.selectedCustomer, 
                {
                    onSuccess: () => {
                        ElMessage({
                            message: 'Customer created successfully',
                            type: 'success',
                        });
                        this.getCustomersFromDb();//get customers again, so that the new customer is displayed
                    },
                    onError: (errors) => {
                        ElMessage.error('Oops, something went wrong while creating a new customer.')
                        ElMessage(errors);
                    }
                }
            )
        },

        editCustomer() {
            router.put(
                `/customers/${this.selectedCustomer.id}`, 
                this.selectedCustomer,
                {
                    onSuccess: () => {
                        ElMessage({
                            message: 'Customer edited successfully',
                            type: 'success',
                        });
                        this.getCustomersFromDb();//get customers again, so that the new customer is displayed
                    },
                    onError: (errors) => {
                        ElMessage.error('Oops, something went wrong while editing a new customer.')
                        ElMessage(errors);
                    }
                }
            )
        },

        setSortOrder(order) {
            this.sortOrder = order;
        },

        setSortColumn(column) {
            this.sortColumn = column;
        },

        setNewItemsPerPage(newItemsPerPage) {
            this.newItemsPerPage = newItemsPerPage;
        },

        setPage(page) {
            this.page = page;
        },

        setSearchTerm(searchTerm) {
            this.searchTerm = searchTerm;
        },

        setElDialogVisible(elDialogVisible) {
            this.elDialogVisible = elDialogVisible;
        },

        setTitle(title) {
            this.title = title;
        },

        setMode(mode) {
            this.mode = mode;
        },

        setSelectedCustomer(selectedCustomer) {
            this.selectedCustomer = selectedCustomer;
        },
    },
});