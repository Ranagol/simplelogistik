import { defineStore } from 'pinia';

export const useCustomerStore = defineStore(
    'customer', {
    state: () => ({
        customers: [],
    }),
    getters: {
        getCustomers() {
            return this.customers;
        },
    },
    actions: {
        setCustomers(customers) {
            this.customers = customers;
        },
    },
});