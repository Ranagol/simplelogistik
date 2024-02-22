import base from "@/config/Pages/Customer/TabContent/base"
import individualSettings from "@/config/Pages/Customer/TabContent/individualSettings"
import addresses from "@/config/Pages/Customer/TabContent/addresses"
import comments from "@/config/Pages/Customer/TabContent/comments"
import contacts from "@/config/Pages/Customer/TabContent/contacts"
import invoices from "@/config/Pages/Customer/TabContent/invoices"
import offers from "@/config/Pages/Customer/TabContent/offers"
import orders from "@/config/Pages/Customer/TabContent/orders"

import {
    index,create,store,destroy,update
} from "@/config/actionPresets";

export default {
    title: "pages.customers.title",
    type: "tabs",
    useContent: {
        index: false,
        create: false,
        edit: true,
    },
    actions: {
        alignment: "justify-start",
        position: "top",
        buttons: [
            index
        ]
    },
    tabs: [
        {
            title: "tabs.generalCustomerData",
            name: "name-generalCustomerData",
            id: 'id-generalCustomerData',
            content: base
        },
        {
            title: "tabs.individualSettings",
            name: "name-individualSettings",
            id: 'id-individualSettings',
            content: individualSettings
        },
        {
            title: "tabs.comments",
            name: "name-comments",
            id: 'id-comments',
            content: comments
        },
        {
            title: "tabs.addresses",
            name: "name-addresses",
            id: 'id-addresses',
            content: addresses
        },
        {
            title: "tabs.contacts",
            name: "name-contacts",
            id: 'id-contacts',
            content: contacts
        },
        {
            title: "tabs.orders",
            name: "name-orders",
            id: 'id-orders',
            content: orders
        },
        {
            title: "tabs.offers",
            name: "name-offers",
            id: 'id-offers',
            content: offers
        },
        {
            title: "tabs.invoices",
            name: "name-invoices",
            id: 'id-invoices',
            content: invoices
        },
    ]
}