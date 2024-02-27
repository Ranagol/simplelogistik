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