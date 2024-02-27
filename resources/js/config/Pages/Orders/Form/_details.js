export default {
    sections: [
        {
            title: "pages.orders.form.sections.order_details",
            sectionType: "default",
            collapsible: true,
            rows: [
                {
                    className: 'grid-flow-row gap-4',
                    fields: [
                        {
                            name: 'type_of_transport',
                            type: 'text',
                            keyName: 'id',
                            className: 'col-auto',
                            placeholder: 'pages.orders.form.type_of_transport',
                            label: 'pages.orders.form.type_of_transport',
                        },
                        {
                            name: 'order_status_id',
                            type: 'text',
                            className: 'col-auto',
                            placeholder: 'pages.orders.form.order_status',
                            label: 'pages.orders.form.order_status',
                        },
                    ]
                },
                {
                    className: 'grid-flow-row gap-4',
                    fields: [
                        {
                            name: 'partner',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.orders.form.partner',
                            label: 'pages.orders.form.partner',
                        },
                        {
                            name: 'origin',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.orders.form.origin',
                            label: 'pages.orders.form.origin',
                        },
                        {
                            name: 'type_of_transport',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.orders.form.first_name',
                            label: 'pages.orders.form.first_name',
                        },
                        {
                            name: 'type_of_transport',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.orders.form.first_name',
                            label: 'pages.orders.form.first_name',
                        },
                    ]
                },
                {
                    className: 'grid-flow-row gap-4',
                    fields: [
                        {
                            name: 'type_of_transport',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.orders.form.first_name',
                            label: 'pages.orders.form.first_name',
                        },
                        {
                            name: 'type_of_transport',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.orders.form.first_name',
                            label: 'pages.orders.form.first_name',
                        },
                    ]
                },
                {
                    className: 'grid-flow-row gap-4',
                    fields: [
                        {
                            name: 'type_of_transport',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.orders.form.first_name',
                            label: 'pages.orders.form.first_name',
                        },
                        {
                            name: 'type_of_transport',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.orders.form.first_name',
                            label: 'pages.orders.form.first_name',
                        }
                    ]
                },
            ]
        },
        {
            title: "pages.orders.form.sections.parcels",
            sectionType: "parcel",
            collapsible: true,
            data: "parcels",
            rows: [
                {
                    className: 'grid-flow-row gap-4',
                    fields: [
                        {
                            name: 'parcel_type',
                            type: 'select',
                            keyName: 'id',
                            className: 'col-auto min-w-48 w-48',
                            placeholder: 'pages.orders.form.parcel_type',
                            label: 'pages.orders.form.parcel_type',
                        },
                        {
                            name: 'length',
                            type: 'text',
                            keyName: 'id',
                            className: 'col-auto',
                            placeholder: 'pages.orders.form.length',
                            label: 'pages.orders.form.length',
                        },
                        {
                            name: 'width',
                            type: 'text',
                            className: 'col-auto',
                            placeholder: 'pages.orders.form.width',
                            label: 'pages.orders.form.width',
                        },
                        {
                            name: 'height',
                            type: 'text',
                            className: 'col-auto',
                            placeholder: 'pages.orders.form.height',
                            label: 'pages.orders.form.height',
                        },
                        {
                            name: 'weight',
                            type: 'text',
                            className: 'col-auto',
                            placeholder: 'pages.orders.form.weight',
                            label: 'pages.orders.form.weight',
                        },
                    ]
                }
            ]
        },
        {
            title: "pages.orders.form.sections.orders",
            sectionType: "default",
            collapsible: true,
            rows: []
        },
        {
            title: "pages.orders.form.sections.finances",
            sectionType: "default",
            collapsible: true,
            rows: []
        },
        {
            title: "pages.orders.form.sections.vehicles",
            sectionType: "default",
            collapsible: true,
            rows: []
        }
    ]
}