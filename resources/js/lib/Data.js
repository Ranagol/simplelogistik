import axios from "axios";

export default class Data {
    async #countries(){
        let countries = await axios.get('/api/countries');
        return countries;
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