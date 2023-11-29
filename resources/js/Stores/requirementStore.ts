import { defineStore } from 'pinia';
import { TmsRequirement } from '@/types/model_to_type';
import { TmsRequirements } from '@/types/model_to_type';
import { PaginationData } from '@/types/customTypes';

export const useRequirementStore = defineStore(
    'vehicle', {

    state: () => ({
        requirements: [] as TmsRequirements,//these are requirements
        selectedRequirement: {} as TmsRequirement,//for edit, create, delete
        selectedRequirements: [] as TmsRequirements,//this is for batch delete
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

        requirementsToStore(requirements: TmsRequirements) {
            this.requirements = requirements;
        },

        deleteRequirement(vehicle: TmsRequirement) {
            this.requirements = this.requirements.filter((item) => item.id !== vehicle.id);
        },

        /**
         * Here we simply find the index of the object that we want to edit, and then replace it with
         * the newly edited object.
         */
        editRequirement() {
            let newlyEditedRequirement = this.selectedRequirement;
            let index = this.requirements.findIndex((nonEditedRequirement) => nonEditedRequirement.id === newlyEditedRequirement.id);
            this.requirements[index] = newlyEditedRequirement;
        },

        setCurrentPage(page: number) {
            this.paginationData.current_page = page;
        },

        setPageSize(size: number) {
            this.paginationData.per_page = size;
        },
    },
});