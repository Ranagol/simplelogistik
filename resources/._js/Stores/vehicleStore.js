import { defineStore } from 'pinia';

export const useVehicleStore = defineStore(
    'vehicle', {

    state: () => ({
        vehicles: [],//these are vehicles
        selectedVehicle: {},//for edit, create, delete
        selectedVehicles: [],//this is for batch delete
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

        vehiclesToStore(vehicles) {
            this.vehicles = vehicles;
        },

        deleteVehicle(vehicle) {
            this.vehicles = this.vehicles.filter((item) => item.id !== vehicle.id);
        },

        /**
         * Here we simply find the index of the object that we want to edit, and then replace it with
         * the newly edited object.
         */
        editVehicle() {
            let newlyEditedVehicle = this.selectedVehicle;
            let index = this.vehicles.findIndex((nonEditedVehicle) => nonEditedVehicle.id === newlyEditedVehicle.id);
            this.vehicles[index] = newlyEditedVehicle;
        },

        setCurrentPage(page) {
            this.paginationData.current_page = page;
        },

        setPageSize(size) {
            this.paginationData.per_page = size;
        },
    },
});