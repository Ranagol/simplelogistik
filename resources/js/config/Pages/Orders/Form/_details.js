export default {
    sections: {
        general: {
            rows: [
                {
                    className: 'grid-flow-col grid-cols-2 gap-4',
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
                            className: 'col-1',
                            type: 'select',
                            options: "orderstatuses",
                            displayKey: 'name',
                            match: "id",
                            className: 'col-auto bg-red-400',
                            placeholder: 'pages.orders.form.order_status',
                            label: 'pages.orders.form.order_status',
                        },
                    ]
                },
                {
                    className: 'grid-flow-col grid-cols-2 gap-4',
                    fields: [
                        {
                            name: 'id',
                            subfield: 'partner',
                            type: 'select',
                            options: "partners",
                            displayKey: 'company_name',
                            match: "id",
                            placeholder: 'pages.orders.form.partner',
                            label: 'pages.orders.form.partner',
                            className: "grid-flow-col bg-blue-400"
                        },
                        {
                            name: 'origin',
                            type: 'select',
                            options: "origins",
                            displayKey: 'title',
                            match: 'id',
                            placeholder: 'pages.orders.form.origin',
                            label: 'pages.orders.form.origin',
                            className: "grid-flow-col bg-blue-400"
                        },
                        {
                            name: 'customer_reference',
                            type: 'text',
                            placeholder: 'pages.orders.form.customer_refernce',
                            label: 'pages.orders.form.customer_refernce',
                            className: "grid-flow-col bg-blue-400"
                        },
                        {
                            name: "details",
                            subfield: 'distance_km',
                            type: 'text',
                            placeholder: 'pages.orders.form.distance_km',
                            label: 'pages.orders.form.distance_km',
                            className: "grid-flow-col bg-blue-400"
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
                    name: 'parcel_type',
                    type: 'select',
                    options: "packingtypes",
                    displayKey: 'title',
                    match: 'id',
                    className: 'col-auto',
                    placeholder: 'pages.orders.form.length',
                    label: 'pages.orders.form.length',
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
        },
        addresses: {
            className: "grid-cols-3 gap-4",
            rows: [
                {className: "", fields : [
                    {
                        name: 'address_type',
                        type: 'badge_dd',
                        className: 'col-auto',
                        placeholder: 'pages.addresses.type',
                        label: 'pages.addresses.type',
                    },
                ]},
                {className: "", fields : [
                    {
                        name: 'first_name',
                        type: 'text',
                        className: 'col-span-2',
                        placeholder: 'pages.customers.form.first_name',
                        label: 'pages.customers.form.first_name',
                    },
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
                ]},
                {className: "", fields : [
                    {
                        name: 'zip_code',
                        type: 'text',
                        className: 'col-span-2',
                        placeholder: 'pages.customers.form.zip_code',
                        label: 'pages.customers.form.zip_code',
                    },
                    {
                        name: 'city',
                        type: 'text',
                        className: 'col-auto',
                        placeholder: 'pages.customers.form.city',
                        label: 'pages.customers.form.city',
                    },
                ]},
                {className: "", fields : [
                    {
                        subfield: 'country_name',
                        name: 'country',
                        type: 'text',
                        className: 'col-span-2',
                        placeholder: 'pages.customers.form.country',
                        label: 'pages.customers.form.country',
                    }
                ]},
                {className: "", fields : [
                    {
                        name: 'phone',
                        type: 'text',
                        className: 'col-span-2',
                        placeholder: 'pages.customers.form.phone',
                        label: 'pages.customers.form.phone',
                    },
                ]},
                {className: "", fields : [
                    {
                        name: 'email',
                        type: 'text',
                        className: 'col-auto',
                        placeholder: 'pages.customers.form.email',
                        label: 'pages.customers.form.email',
                    },
                ]},
            ],
        },
    }   
}

