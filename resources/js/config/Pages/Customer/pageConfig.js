import base from "@Config/Pages/Customer/TabContent/base"
import individualSettings from "@Config/Pages/Customer/TabContent/individualSettings"
import addresses from "@Config/Pages/Customer/TabContent/addresses"
import comments from "@Config/Pages/Customer/TabContent/comments"
import contacts from "@Config/Pages/Customer/TabContent/contacts"
import invoices from "@Config/Pages/Customer/TabContent/invoices"
import offers from "@Config/Pages/Customer/TabContent/offers"
import orders from "@Config/Pages/Customer/TabContent/orders"

export default {
    title: "pages.customers.title",
    type: "tabs",
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
            content: addresses
        },
        {
            title: "tabs.addresses",
            name: "name-addresses",
            id: 'id-addresses',
            content: comments
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
            content: invoices
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
            content: orders
        },
    ]
}