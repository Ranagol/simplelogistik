import { defineStore } from 'pinia';

export const useRequirementStore = defineStore(
    'vehicle', {

    state: () => ({
        requirements: [],//these are requirements
        selectedRequirement: {},//for edit, create, delete
        selectedRequirements: [],//this is for batch delete
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

        requirementsToStore(requirements) {
            this.requirements = requirements;
        },

        deleteRequirement(vehicle) {
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

        setCurrentPage(page) {
            this.paginationData.current_page = page;
        },

        setPageSize(size) {
            this.paginationData.per_page = size;
        },
    },
});