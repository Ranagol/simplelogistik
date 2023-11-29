import { defineStore } from 'pinia';
import { TmsCustomer } from '@/types/model_to_type';
import { TmsCustomers } from '@/types/model_to_type';
import { PaginationData, CustomerErrors } from '@/types/customTypes';

export const useCustomerStore = defineStore(
    'customer', {

    state: () => ({
        customers: [] as TmsCustomers,//these are customers
        selectedCustomer: {} as TmsCustomer,//for edit, create, delete
        selectedObjects: [] as TmsCustomers,//this is for batch delete
        searchTerm: '',//for search field
        mode: '',
        elDialogVisible: false as boolean,//turns on the popup

        //sort in el-table
        sortOrder: '' as string | undefined,
        sortColumn: '' as string | undefined,

        //pagination
        paginationData: {} as PaginationData,

        errors: {
            company_name: '',
            name: '',
            email: '',
            rating: '',
            tax_number: '',
            internal_cid: '',
        } as CustomerErrors,//validation errors from the backend
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