import axios from "axios";

export default class Data {
    async #countries(){
        let countries = await axios.get('/api/countries');
        return countries;
    }
    async #ratings(){
        let ratings = await axios.get('/api/ratings');
        return ratings;
    }
    async #ism(){
        let ism = await axios.get('/api/invocie-shipping-methods');
        return ism;
    }
    async #orderstatuses(){
        let orderstatuses = await axios.get('/api/order-statuses');
        return orderstatuses;
    }
    async #invoicedispatch(){
        let invoicedispatch = await axios.get('/api/invocie-dispatch');
        return invoicedispatch;
    }
    async #customertypes(){
        let ct = await axios.get('/api/customer-types');
        return ct;
    }
    async #paymentmethods(){
        let ct = await axios.get('/api/payment-methods');
        return ct;
    }
    async #forwarders(){
        let forwarders = await axios.get('/api/forwarders');
        return forwarders;
    }
    async #customers(){
        let customers = await axios.get('/api/customers');
        return customers;
    }
    async #addresses(){
        let addresses = await axios.get('/api/addresses');
        return addresses;
    }
    async #partners(){
        let partners = await axios.get('/api/partners');
        return partners;
    }

    async getData(target){
        
        switch(target){
            case 'countries':
                return await this.#countries();
            case 'ratings':
                return await this.#ratings();
            case 'ism':
                return await this.#ism();
            case 'invoicedispatch':
                return await this.#invoicedispatch();
            case 'customertypes':
                return await this.#customertypes();
            case 'orderstatuses':
                return await this.#orderstatuses();
            case 'paymentmethods':
                return await this.#paymentmethods();
            case 'forwarders':
                return await this.#forwarders();
            case 'customers':
                return await this.#customers();
            case 'addresses':
                return await this.#addresses();
            case 'partners':
                return await this.#partners();
        }
    }
}