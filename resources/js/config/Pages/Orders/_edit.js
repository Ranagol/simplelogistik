import { Notebook, Bell, Location, FolderOpened, User, Sort } from "@element-plus/icons-vue"

import OrderEditDetails from "@/Pages/Orders/Parts/OrderEditDetails.vue"
import OrderInfotool from "@/Pages/Orders/Parts/OrderInfotool.vue"
import OrderTracking from "@/Pages/Orders/Parts/OrderTracking.vue"
import OrderInvoices from "@/Pages/Orders/Parts/OrderInvoices.vue"
import OrderCustomerNotes from "@/Pages/Orders/Parts/OrderCustomerNotes.vue"
import OrderChangelog from "@/Pages/Orders/Parts/OrderChangelog.vue"

export default {
    title: "",
    preset: "tabs",
    mode: "edit",
    actions: [
        {handler: (data) => {
            alert(`Speichere Auftrag: ${(data?.order_number ?? data.data.order_number)}`)
        }, class: "", title: "buttons.general.save"},
        {handler: (data) => {
            alert(`Storniere Auftrag: ${(data?.order_number ?? data.data.order_number)}`)
        }, class: "bg-red-700 hover:bg-red-600", title: "buttons.general.void"},
    ],
    tabs: [
        {
            "title": "pages.orders.tabs.details",
            "id": "OrderEditDetails",
            "icon": Notebook,
            "component": OrderEditDetails,
            "useContent": true,
        },
        {
            "title": "pages.orders.tabs.infotool",
            "id": "OrderInfotool",
            "icon": Bell,
            "component": OrderInfotool,
            "useContent": true, 
        },
        {
            "title": "pages.orders.tabs.tracking",
            "id": "OrderTracking",
            "icon": Location,
            "component": OrderTracking,
            "useContent": true, 
        },
        {
            "title": "pages.orders.tabs.invoices",
            "id": "OrderInvoices",
            "icon": FolderOpened,
            "component": OrderInvoices,
            "useContent": true, 
        },
        {
            "title": "pages.orders.tabs.comments",
            "id": "OrderCustomerNotes",
            "icon": User,
            "component": OrderCustomerNotes,
            "useContent": true, 
        },
        {
            "title": "pages.orders.tabs.changelog",
            "id": "OrderChangelog",
            "icon": Sort,
            "component": OrderChangelog,
            "useContent": true, 
        },
    ]
}