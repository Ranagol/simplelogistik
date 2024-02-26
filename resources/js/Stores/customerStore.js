import { router } from '@inertiajs/vue3';
import { defineStore } from 'pinia';
export const store = defineStore('address', {
    state: () => ({
        record: {},
        records: []
    }),

    actions: {
        set(records) {
            this.records = records;
        },
        get() {
            return this.records;
        },
        setOne(record) {
            this.record = record;
        },
        getOne() {
            return this.record;
        },
        store(){
            router.post(route("customers.store"), this.record);
        },
        save(){
            router.put(route("customers.update", this.record.id ), this.record);
        },
        update( field, value ){
            this.record[field] = value;
        },
        delete(){
            router.delete(route("customers.destroy"), this.record.id);
        }
    }
})