import { defineStore } from 'pinia';
import { TmsAddress } from '@/types/model_to_type';
import { TmsAddresses } from '@/types/model_to_type';
import { PaginationData } from '@/types/customTypes';

export const useAddressStore = defineStore(
    'address', {

    state: () => ({
        addresses: [] as TmsAddresses,//these are addresses
        selectedAddress: {} as TmsAddress,//for edit, create, delete
        selectedAddresses: [] as TmsAddresses,//this is for batch delete
        searchTerm: '',//for search field
        mode: '',
        elDialogVisible: false as boolean,//turns on the popup

        //sort in el-table
        sortOrder: '' as string,
        sortColumn: '' as string,

        //pagination
        paginationData: {} as PaginationData,

        errors: {},//validation errors from the backend
        title: '',//the title for the createEditCustomer component
        addressResetValues: {
            // company_name: '',
            // name: '',
            // email: '',
            // rating: '',
            // tax_number: '',
            // internal_cid: '',
        },
    }),

    getters: {//like computed properties. Use state here.

    },

    actions: {//like methods. Use .this here

        addressesToStore(addresses: TmsAddresses) {
            this.addresses = addresses;
        },

        deleteAddress(address: TmsAddress) {
            this.addresses = this.addresses.filter((item) => item.id !== address.id);
        },

        editAddress() {
            let newlyEditedAddress = this.selectedAddress;
            let index = this.addresses.findIndex((nonEditedAddress) => nonEditedAddress.id === newlyEditedAddress.id);
            this.addresses[index] = newlyEditedAddress;
        },

        setCurrentPage(page: number) {
            this.paginationData.current_page = page;
        },

        setPageSize(size: number) {
            this.paginationData.per_page = size;
        },
    },
});