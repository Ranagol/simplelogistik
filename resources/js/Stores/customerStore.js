import { router } from '@inertiajs/vue3';
import { defineStore } from 'pinia';
export const store = defineStore('address', {
    state: () => ({
        record: {},
        records: []
    }),

    getters: {
        
    },
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
            this.record.rating = parseInt(this.record.rating);
            this.record.payment_time = parseInt(this.record.payment_time);
            this.record.customer_type = parseInt(this.record.customer_type);
            this.record.easy_bill_customer_id = parseInt(this.record.easy_bill_customer_id);
            this.record.invoice_dispatch = parseInt(this.record.invoice_dispatch);
            this.record.invoice_shipping_method = parseInt(this.record.invoice_shipping_method);
            this.record.payment_method_options_to_offer = [];

            router.post(route("customers.store"), this.record);
        },
        save(){
            this.record.rating = parseInt(this.record.rating);
            this.record.payment_time = parseInt(this.record.payment_time);
            this.record.customer_type = parseInt(this.record.customer_type);
            this.record.easy_bill_customer_id = parseInt(this.record.easy_bill_customer_id);
            this.record.invoice_dispatch = parseInt(this.record.invoice_dispatch);
            this.record.invoice_shipping_method = parseInt(this.record.invoice_shipping_method);
            this.record.payment_method_options_to_offer = [];

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