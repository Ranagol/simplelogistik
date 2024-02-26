import {edit, cancel} from "@/config/actionPresets";

export default {
    title: "pages.orders.index",
    preset: "complex-table",
    bodyContentSettings: {
        rows: [
            {
                sectionTitle: "tables.orders.details.addresses",
                type: "addressBox",
                show: {
                    from: "addresses", 
                    fields: [
                        {type: "badge", postion: 'top|right', field: "address_type"},
                        {type: "single", field: "company_name"},
                        {type: "group", field: ["first_name", "last_name"]},
                        {type: "group", field: ["street", "house_number"]},
                        {type: "group", field: ["zip_code", "city"]},
                        {type: "single", field: "state"},
                        {type: "single", field: "country"}
                    ]
                },
            },
            {
                sectionTitle: "tables.orders.details.parcels",
                type: "parcelsBox",
                show: {
                    label: "tables.orders.labels.parcel",
                    fields: [
                        {from: false, type: "badge", postion: 'top|right', field: "type_of_transport"},
                        {from: "parcels", label: "labels.general.measurements", join: " x ", type: "group", field: ["width", "length", "height"]},
                        {from: "parcels", label: "labels.general.weight", type: "single", field: "weight"},
                    ]
                }
            },
            {
                sectionTitle: "tables.orders.details.details",
                type: "detailsBox",
                show: {
                    fields: [
                        {from: "forwarder", label: "labels.general.name", field: "name"},
                        {from: false, label: "labels.general.order_number", field: "order_number"},
                        {from: false, label: "labels.general.payment_method", field: "payment_method"},
                        {from: false, label: "labels.general.purchase_price", field: "purchase_price"},
                        {from: "customer", label: "labels.general.customer_number", field: "customer_number"},
                        {from: "details", label: "labels.general.distance_km", field: "distance_km"},
                        {from: "details", label: "labels.general.duration_minutes", field: "duration_minutes"},
                        {from: "details", label: "labels.general.price_net", field: "price_net"},
                    ]
                },
            },
        ],
        actions: {
            alignment: "justify-between",
            left: [edit, cancel],
            right: [
                {"type": "button", "action": "downloads.shipping-label", "label": "buttons.download_shipping_label", "icon": "false"},
                {"type": "dropdown", "action": "downloads.transport-document", "label": "buttons.download_order_documents", "icon": "false"},
            ]
        }
    }
}