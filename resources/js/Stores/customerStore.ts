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
    }),

    getters: {//like computed properties. Use state here.
        getEldDialogVisible() {
            return this.elDialogVisible;
        }
    },

    actions: {//like methods. Use .this here

        getCustomersFromDb(
            searchTerm = '',
            sortColumn = '',
            sortOrder = '',
            page = '',
            newItemsPerPage = '',
            elDialogVisible = false,
        ) {
            this.customers = router.get(
                '/customers',
                {
                    /**
                     * This is the data that we send to the backend.
                     */
                    searchTerm,
                    sortColumn,
                    sortOrder,
                    page,
                    newItemsPerPage,
                    elDialogVisible,
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
            console.log('createCustomer from Pinia triggered');
            console.log('this is the selected customer', this.selectedCustomer);
            router.post(
                '/customers', 
                this.selectedCustomer, 
                {
                    onSuccess: () => {
                        ElMessage({
                            message: 'Customer created successfully',
                            type: 'success',
                        });
                        // this.getCustomersFromDb();//get customers again, so that the new customer is displayed
                        this.elDialogVisible = false;
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
        
    },
});