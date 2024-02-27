import { router } from '@inertiajs/vue3';
import { defineStore } from 'pinia';
export const store = defineStore('address', {
    state: () => ({
        record: {
        },
        records: [],
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
        save(){
            this.record.customer_id = parseInt(this.record.customer_id);
            this.record.forwarder_id = parseInt(this.record.forwarder_id);
            this.record.salutation_id = parseInt(this.record.salutation_id);
            this.record.title_id  = parseInt(this.record.title_id);
            this.record.country_id = parseInt(this.record.country_id);
            router.put(route("addresses.update", this.record.id ), this.record);
        },
        store(){
            this.record.customer_id = parseInt(this.record.customer_id);
            this.record.forwarder_id = parseInt(this.record.forwarder_id);
            this.record.salutation_id = parseInt(this.record.salutation_id);
            this.record.title_id  = parseInt(this.record.title_id);
            this.record.country_id = parseInt(this.record.country_id);
            router.post(route("addresses.store"), this.record);
        },
        update( field, value ){
            this.record[field] = value;
        },
        delete(){
            router.delete(route("addresses.destroy"), this.record.id);
        }
    }
})