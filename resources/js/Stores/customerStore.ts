import { defineStore } from 'pinia';

export const useCustomerStore = defineStore(
    'customer', {

    state: () => ({
        customers: [],
        selectedCustomer: {},
        mode: '',
        elDialogVisible: false,
        errors: {},
        title: '',
        customerResetValues: {
            company_name: '',
            name: '',
            email: '',
            rating: '',
            tax_number: '',
            internal_cid: '',
        },
    }),

    getters: {//like computed properties. Use state here.

    },

    actions: {//like methods. Use .this here

        customersToStore(customers) {
            this.customers = customers;
        },

        deleteCustomer(customer) {
            this.customers = this.customers.filter((item) => item.id !== customer.id);
        },

        editCustomer() {
            let newlyEditedCustomer = this.selectedCustomer;
            let index = this.customers.findIndex((nonEditedcustomer) => nonEditedcustomer.id === newlyEditedCustomer.id);
            this.customers[index] = newlyEditedCustomer;
        }
    },
});