export default {
    sections: {
        general: {
            rows: [
                {
                    className: 'grid-cols-2 gap-4',
                    fields: [
                        {
                            name: 'type_of_transport',
                            className: 'col-1',
                            placeholder: 'pages.orders.form.type_of_transport',
                            label: 'pages.orders.form.type_of_transport',
                            type: 'text',
                        },
                        {
                            name: 'order_status_id',
                            type: 'select',
                            options: "orderstatuses",
                            displayKey: 'internal_name',
                            match: "id",
                            className: 'col-1',
                            placeholder: 'pages.orders.form.order_status',
                            label: 'pages.orders.form.order_status',
                        },
                    ]
                },
                {
                    className: 'grid-cols-4 gap-4',
                    fields: [
                        {
                            name: 'id',
                            subfield: 'partner',
                            className: 'col-1',
                            type: 'select',
                            options: "partners",
                            displayKey: 'company_name',
                            match: "id",
                            placeholder: 'pages.orders.form.partner',
                            label: 'pages.orders.form.partner',
                        },
                        {
                            name: 'origin',
                            className: 'col-1',
                            type: 'select',
                            options: "origins",
                            displayKey: 'title',
                            match: 'id',
                            placeholder: 'pages.orders.form.origin',
                            label: 'pages.orders.form.origin',
                        },
                        {
                            name: 'customer_reference',
                            className: 'col-1',
                            type: 'text',
                            placeholder: 'pages.orders.form.customer_refernce',
                            label: 'pages.orders.form.customer_refernce',
                        },
                        {
                            name: "details",
                            subfield: 'distance_km',
                            className: 'col-1',
                            type: 'text',
                            placeholder: 'pages.orders.form.distance_km',
                            label: 'pages.orders.form.distance_km',
                        },
                    ]
                },
                {
                    className: 'grid-cols-2 gap-4',
                    fields: [
                        {
                            name: 'details',
                            subfield: 'duration_minutes',
                            className: 'col-1',
                            type: 'text',
                            placeholder: 'pages.orders.form.duration_minutes',
                            label: 'pages.orders.form.duration_minutes',
                        },
                        {
                            name: 'details',
                            subfield: 'calculation_model_name',
                            className: 'col-1',
                            type: 'text',
                            placeholder: 'pages.orders.form.calculation_model_name',
                            label: 'pages.orders.form.calculation_model_name',
                        },
                    ]
                },
                {
                    className: 'grid-cols-2 gap-4',
                    fields: [
                        {
                            name: 'details',
                            subfield: 'particularities',
                            className: 'col-1',
                            type: 'text',
                            placeholder: 'pages.orders.form.particularities',
                            label: 'pages.orders.form.particularities',
                        },
                        {
                            name: 'details',
                            subfield: 'description_of_transport',
                            className: 'col-1',
                            type: 'text',
                            placeholder: 'pages.orders.form.description_of_transport',
                            label: 'pages.orders.form.description_of_transport',
                        }
                    ]
                },
            ]
        },
        parcels: {
            fields: [
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
        },
        addresses: {
            rows: [
                {className: "", fields : [
                    {
                        name: 'address_type',
                        type: 'text',
                        className: 'col-auto',
                        placeholder: 'pages.addresses.type',
                        label: 'pages.addresses.type',
                    },
                ]},
                {className: "", fields : [
                    {
                        name: 'first_name',
                        type: 'text',
                        className: 'col-auto',
                        placeholder: 'pages.customers.form.first_name',
                        label: 'pages.customers.form.first_name',
                    },
                ]},
                {className: "", fields : [
                    {
                        name: 'last_name',
                        type: 'text',
                        className: 'col-auto',
                        placeholder: 'pages.customers.form.last_name',
                        label: 'pages.customers.form.last_name',
                    },
                ]},
                {className: "", fields : [
                    {
                        name: 'street',
                        type: 'text',
                        className: 'col-auto',
                        placeholder: 'pages.customers.form.street',
                        label: 'pages.customers.form.street',
                    },
                    {
                        name: 'house_number',
                        type: 'text',
                        className: 'col-auto',
                        placeholder: 'pages.customers.form.house_number',
                        label: 'pages.customers.form.house_number',
                    },
                ]}
            ],
        },
    }   
}

