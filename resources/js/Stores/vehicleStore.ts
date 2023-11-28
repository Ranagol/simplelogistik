import { defineStore } from 'pinia';
import { TmsVehicle } from '@/types/model_to_type';
import { TmsVehicles } from '@/types/model_to_type';
import { PaginationData } from '@/types/customTypes';

export const useVehicleStore = defineStore(
    'vehicle', {

    state: () => ({
        vehicles: [] as TmsVehicles,//these are vehicles
        selectedVehicle: {} as TmsVehicle,//for edit, create, delete
        selectedVehicles: [] as TmsVehicles,//this is for batch delete
        searchTerm: '',//for search field
        mode: '',
        elDialogVisible: false as boolean,//turns on the popup

        //sort in el-table
        sortOrder: '' as string,
        sortColumn: '' as string,

        //pagination
        paginationData: {} as PaginationData,

        errors: {},//validation errors from the backend
        title: '',//the title for the createEdit component
    }),

    getters: {//like computed properties. Use state here.

    },

    actions: {//like methods. Use .this here

        vehiclesToStore(vehicles: TmsVehicles) {
            this.vehicles = vehicles;
        },

        deleteVehicle(vehicle: TmsVehicle) {
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

        setCurrentPage(page: number) {
            this.paginationData.current_page = page;
        },

        setPageSize(size: number) {
            this.paginationData.per_page = size;
        },
    },
});