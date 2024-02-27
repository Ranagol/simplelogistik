export default {
    sections: [
        {
            title: "pages.orders.tabs.order_details",
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
                            placeholder: 'pages.addresses.form.type_of_transport',
                            label: 'pages.addresses.form.type_of_transport',
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
        }
    ]
}