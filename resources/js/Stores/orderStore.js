import { router } from '@inertiajs/vue3';
import { defineStore } from 'pinia';
export const store = defineStore('order', {
    state: () => ({
        record: {},
        records: []
    }),

    actions: {
        set(orders) {
            this.records = orders;
        },
        get() {
            return this.records;
        },
        setOne(order) {
            this.record = order;
        },
        getOne() {
            return this.record;
        },
        store(){
            router.post(route("orders.store"), this.record);
        },
        save(){
            router.put(route("orders.update", this.record.id), this.record);
        },
        update( field, value ){
            this.record[field] = value;
        },
        delete(){
            router.delete(route("orders.destroy"), this.record.id);
        }
    }
})