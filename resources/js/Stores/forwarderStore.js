import { router } from '@inertiajs/vue3';
import { defineStore } from 'pinia';
export const store = defineStore('forwarder', {
    state: () => ({
        record: {},
        records: []
    }),

    actions: {
        set(forwarders) {
            this.records = forwarders;
        },
        get() {
            return this.records;
        },
        setOne(forwarder) {
            this.record = forwarder;
        },
        getOne() {
            return this.record;
        },
        store(){
            this.record.rating = parseInt(this.record.rating);
            router.post(route("forwarders.store"), this.record);
        },
        save(){
            this.record.rating = parseInt(this.record.rating);
            router.put(route("forwarders.update", this.record.id), this.record);
        },
        update( field, value ){
            this.record[field] = value;
        },
        delete(){
            router.delete(route("forwarders.destroy"), this.record.id);
        }
    }
})