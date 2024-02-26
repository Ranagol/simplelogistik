import { defineStore } from 'pinia';

export const useAddressStore = defineStore(
    'address', {

    state: () => ({
        addresses: [],//these are addresses
        selectedAddress: {},//for edit, create, delete
        selectedAddresses: [],//this is for batch delete
        searchTerm: '',//for search field
        mode: '',
        elDialogVisible: false,//turns on the popup

        //sort in el-table
        sortOrder: '',
        sortColumn: '',

        //pagination
        paginationData: {},

        errors: {},//validation errors from the backend
        title: '',//the title for the createEdit component
    }),

    getters: {//like computed properties. Use state here.

    },

    actions: {//like methods. Use .this here

        addressesToStore(addresses) {
            this.addresses = addresses;
        },

        deleteAddress(address) {
            this.addresses = this.addresses.filter((item) => item.id !== address.id);
        },

        editAddress() {
            let newlyEditedAddress = this.selectedAddress;
            let index = this.addresses.findIndex((nonEditedAddress) => nonEditedAddress.id === newlyEditedAddress.id);
            this.addresses[index] = newlyEditedAddress;
        },

        setCurrentPage(page) {
            this.paginationData.current_page = page;
        },

        setPageSize(size) {
            this.paginationData.per_page = size;
        },
    },
});