import { defineStore } from 'pinia';
import { TmsCustomer } from '@/types/model_to_type';
import { TmsCustomers } from '@/types/model_to_type';
import { PaginationData } from '@/types/customTypes';

export const useCustomerStore = defineStore(
    'customer', {

    state: () => ({
        customers: [] as TmsCustomers,//these are customers
        selectedCustomer: {} as TmsCustomer,//for edit, create, delete
        selectedObjects: [] as TmsCustomers,//this is for batch delete
        searchTerm: '',//for search field
        mode: '',
        elDialogVisible: true as boolean,//turns on the popup

        //sort in el-table
        sortOrder: '' as string,
        sortColumn: '' as string,

        //pagination
        paginationData: {} as PaginationData,

        errors: {},//validation errors from the backend
        title: '',//the title for the createEditCustomer component
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

        customersToStore(customers: TmsCustomers) {
            this.customers = customers;
        },

        deleteCustomer(customer: TmsCustomer) {
            this.customers = this.customers.filter((item) => item.id !== customer.id);
        },

        editCustomer() {
            let newlyEditedCustomer = this.selectedCustomer;
            let index = this.customers.findIndex((nonEditedcustomer) => nonEditedcustomer.id === newlyEditedCustomer.id);
            this.customers[index] = newlyEditedCustomer;
        },

        setCurrentPage(page: number) {
            this.paginationData.current_page = page;
        },

        setPageSize(size: number) {
            this.paginationData.per_page = size;
        },
    },
});