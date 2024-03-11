import { Notebook, Bell, Location, FolderOpened, User, Sort, ChatRound, Setting, Files } from "@element-plus/icons-vue"

import Details from "@/Pages/Customers/Parts/Details.vue"
import Preferences from "@/Pages/Customers/Parts/Preferences.vue"
import Comments from "@/Pages/Customers/Parts/Comments.vue"
import Addresses from "@/Pages/Customers/Parts/Addresses.vue"
import Contacts from "@/Pages/Customers/Parts/Contacts.vue"
import Orders from "@/Pages/Customers/Parts/Orders.vue"
import Offers from "@/Pages/Customers/Parts/Offers.vue"

export default {
    title: "",
    preset: "tabs",
    mode: "edit",
    actions: [
        {handler: (data) => {
        }, className: "bg-primary-700 text-white hover:bg-primary-600", title: "buttons.general.save"},
            {handler: (data) => {
        }, className: "bg-red-700 text-white hover:bg-red-600", title: "buttons.general.delete"},
    ],
    tabs: [
        {
            "title": "pages.customers.tabs.details",
            "id": "customers_Details",
            "icon": Notebook,
            "component": Details,
            "useContent": true,
        },
        {
            "title": "pages.customers.tabs.preferences",
            "id": "customers_Preferences",
            "icon": Setting,
            "component": Preferences,
            "useContent": true, 
        },
        {
            "title": "pages.customers.tabs.comments",
            "id": "customers_Comments",
            "icon": ChatRound,
            "component": Comments,
            "useContent": true, 
        },
        {
            "title": "pages.customers.tabs.addresses",
            "id": "customers_Addresses",
            "icon": FolderOpened,
            "component": Addresses,
            "useContent": true, 
        },
        {
            "title": "pages.customers.tabs.contacts",
            "id": "customers_Contacts",
            "icon": User,
            "component": Contacts,
            "useContent": true, 
        },
        {
            "title": "pages.customers.tabs.offers",
            "id": "customers_Offers",
            "icon": Files,
            "component": Offers,
            "useContent": true, 
        },
        {
            "title": "pages.customers.tabs.orders",
            "id": "customers_Orders",
            "icon": Files,
            "component": Orders,
            "useContent": true, 
        },
    ]
}