<script setup>
    import Form from '@/Components/Form.vue';
    import _config from '@/config/Pages/Orders/Form/_changelog';
    defineProps({
        useContent: {
            type: Boolean,
            required: false,
        }
    });

    import {store as useStore} from '@/Stores/orderStore';
    import { reactive } from 'vue';
    
    let contentStore = useStore();
    let content = contentStore.getOne();
    
    let history = reactive({
        items: []
    });

    const getStatus = async (id) => {
        let response = await axios.get(`/api/order-status/${id}`)
        history.items[id].name = response.data.description    
    }

</script>
<template>
    <ol class="relative border-gray-200 border-s dark:border-gray-700">               
        
        <li v-for="item,index in content.history" :key="index" class="mb-10 ms-6">    
            {{ getStatus(item.order_status_id) }}        
            <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                <img class="rounded-full shadow-lg" :src="item.user?.profile_image_url ?? '/images/avatar/profile.svg'" :alt="item.user.name"/>
            </span>
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                <div class="items-center justify-between mb-3 sm:flex">
                    <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ moment(item.created_at).fromNow() }}</time>
                    <div class="text-sm font-normal text-gray-500 lex dark:text-gray-300">{{ item.user.name }}  <a href="#" class="font-semibold text-gray-900 dark:text-white hover:underline">{{ history.items[id].name }}</a></div>
                </div>
                <div class="p-3 text-xs italic font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">{{ item.details}}</div>
            </div>
        </li>
    </ol>
</template>
