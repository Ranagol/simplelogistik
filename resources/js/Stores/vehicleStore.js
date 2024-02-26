import { router } from '@inertiajs/vue3';
import { defineStore } from 'pinia';
export const store = defineStore('customer', {
    state: () => ({
        record: {},
        records: []
    }),

    actions: {
        set(vehicles) {
            this.records = vehicles;
        },
        get() {
            return this.records;
        },
        setOne(customer) {
            this.record = customer;
        },
        getOne() {
            return this.record;
        },
        store(){
            router.post(route("vehicles.store"), this.record);
        },
        save(){
            router.post(route("vehicles.update", this.record.id), this.record);
        },
        update( field, value ){
            this.record[field] = value;
        },
        delete(){
            router.delete(route("vehicles.destroy"), this.record.id);
        }
    }
})