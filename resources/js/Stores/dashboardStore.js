import { router } from '@inertiajs/vue3';
import { defineStore } from 'pinia';
export const store = defineStore('dashboard', {
    state: () => ({
        orders: [],
    }),
    
    actions: {

        find(item){
            return this.orders.find(order => order.id === item.id);
        },
        remove(item){
            this.orders = this.orders.filter(order => order.id !== item.id);
            sessionStorage.setItem('orders', JSON.stringify(this.orders));
        },
        addOrderToWatchList(order){
            this.orders.push(order);
            sessionStorage.setItem('orders', JSON.stringify(this.orders));
        },
        setOrders(orders){
            this.orders = orders;
            sessionStorage.setItem('orders', JSON.stringify(orders));
        },
        getOrders(){
            this.orders = sessionStorage.getItem('orders') ? JSON.parse(sessionStorage.getItem('orders')) : [];
            return this.orders;
        },
    }
})