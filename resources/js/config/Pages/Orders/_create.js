import { Notebook, Bell, Location, FolderOpened, User, Sort } from "@element-plus/icons-vue"

import OrderEditDetails from "@/Pages/Orders/Parts/OrderEditDetails.vue"
import OrderInfotool from "@/Pages/Orders/Parts/OrderInfotool.vue"
import OrderTracking from "@/Pages/Orders/Parts/OrderTracking.vue"
import OrderInvoices from "@/Pages/Orders/Parts/OrderInvoices.vue"
import OrderCustomerNotes from "@/Pages/Orders/Parts/OrderCustomerNotes.vue"
import OrderChangelog from "@/Pages/Orders/Parts/OrderChangelog.vue"

export default {
    title: "pages.orders.create",
    preset: "tabs",
    mode: "create",
    tabs: [
        {
            "title": "pages.orders.tabs.order_details",
            "id": "OrderEditDetails",
            "icon": Notebook,
            "component": OrderEditDetails,
            "useContent": true,
        },
        {
            "title": "pages.orders.tabs.details",
            "id": "OrderInfotool",
            "icon": Bell,
            "component": OrderInfotool,
            "useContent": true, 
        },
        {
            "title": "pages.orders.tabs.details",
            "id": "OrderTracking",
            "icon": Location,
            "component": OrderTracking,
            "useContent": true, 
        },
        {
            "title": "pages.orders.tabs.details",
            "id": "OrderInvoices",
            "icon": FolderOpened,
            "component": OrderInvoices,
            "useContent": true, 
        },
        {
            "title": "pages.orders.tabs.details",
            "id": "OrderCustomerNotes",
            "icon": User,
            "component": OrderCustomerNotes,
            "useContent": true, 
        },
        {
            "title": "pages.orders.tabs.details",
            "id": "OrderChangelog",
            "icon": Sort,
            "component": OrderChangelog,
            "useContent": true, 
        },
    ]
}