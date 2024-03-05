export default {
    sections: {
        general: {
            rows: [
                {
                    className: 'grid-flow-row grid-cols-2 gap-4',
                    fields: [
                        {
                            name: 'type_of_transport',
                            className: 'col-1',
                            placeholder: '',
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
                            className: 'col-auto',
                            placeholder: '',
                            label: 'pages.orders.form.order_status',
                        },
                    ]
                },
                {
                    className: 'grid-flow-row grid-cols-4 gap-4',
                    fields: [
                        {
                            name: 'id',
                            subfield: 'partner',
                            type: 'select',
                            options: "partners",
                            displayKey: 'company_name',
                            match: "id",
                            placeholder: '',
                            label: 'pages.orders.form.partner',
                            className: "grid-flow-col bg-blue-400"
                        },
                        {
                            name: 'origin',
                            type: 'select',
                            options: "origins",
                            displayKey: 'title',
                            match: 'id',
                            placeholder: '',
                            label: 'pages.orders.form.origin',
                            className: "grid-flow-col bg-blue-400"
                        },
                        {
                            name: 'customer_reference',
                            type: 'text',
                            placeholder: '',
                            label: 'pages.orders.form.customer_refernce',
                            className: "grid-flow-col bg-blue-400"
                        },
                        {
                            name: "details",
                            subfield: 'distance_km',
                            type: 'text',
                            placeholder: '',
                            label: 'pages.orders.form.distance_km',
                            className: "grid-flow-col bg-blue-400"
                        },
                    ]
                },
                {
                    className: 'grid-flow-row grid-cols-2 gap-4',
                    fields: [
                        {
                            name: 'details',
                            subfield: 'duration_minutes',
                            className: 'col-1',
                            type: 'text',
                            placeholder: '',
                            label: 'pages.orders.form.duration_minutes',
                        },
                        {
                            name: 'details',
                            subfield: 'calculation_model_name',
                            className: 'col-1',
                            type: 'text',
                            placeholder: '',
                            label: 'pages.orders.form.calculation_model_name',
                        },
                    ]
                },
                {
                    className: 'grid-flow-row grid-cols-2 gap-4',
                    fields: [
                        {
                            name: 'details',
                            subfield: 'particularities',
                            className: 'col-1',
                            type: 'text',
                            placeholder: '',
                            label: 'pages.orders.form.particularities',
                        },
                        {
                            name: 'details',
                            subfield: 'description_of_transport',
                            className: 'col-1',
                            type: 'text',
                            placeholder: '',
                            label: 'pages.orders.form.description_of_transport',
                        }
                    ]
                },
            ]
        },
        parcels: {
            className: "grid-cols-6 gap-4",
            fields: [
                {
                    name: 'parcel_type',
                    type: 'select',
                    options: "packingtypes",
                    displayKey: 'title',
                    match: 'id',
                    className: 'col-auto',
                    placeholder: '',
                    label: 'pages.orders.form.length',
                },
                {
                    name: 'length',
                    type: 'text',
                    keyName: 'id',
                    className: 'col-auto',
                    placeholder: '',
                    label: 'pages.orders.form.length',
                },
                {
                    name: 'width',
                    type: 'text',
                    className: 'col-auto',
                    placeholder: '',
                    label: 'pages.orders.form.width',
                },
                {
                    name: 'height',
                    type: 'text',
                    className: 'col-auto',
                    placeholder: '',
                    label: 'pages.orders.form.height',
                },
                {
                    name: 'weight',
                    type: 'text',
                    className: 'col-auto',
                    placeholder: '',
                    label: 'pages.orders.form.weight',
                },
            ]
        },
        addresses: {
            rows: [
                { className: "flex gap-4",
                    fields : [
                    {
                        name: 'address_type',
                        type: 'badge_dd',
                        className: 'w-full',
                        placeholder: '',
                        label: 'pages.addresses.type',
                    },
                ]},
                { className: "flex gap-4",
                fields : [
                    {
                        name: 'company_name',
                        type: 'text',
                        className: 'w-full',
                        placeholder: '',
                        label: 'pages.customers.form.company_name',
                    }
                ]},
                { className: "flex gap-4",
                fields : [
                    {
                        name: 'first_name',
                        type: 'text',
                        className: 'w-full',
                        placeholder: '',
                        label: 'pages.customers.form.first_name',
                    },
                    {
                        name: 'last_name',
                        type: 'text',
                        className: 'w-full',
                        placeholder: '',
                        label: 'pages.customers.form.last_name',
                    },
                ]},
                { className: "flex gap-4",
                fields : [
                    {
                        name: 'street',
                        type: 'text',
                        className: 'w-full',
                        placeholder: '',
                        label: 'pages.customers.form.street',
                    },
                    {
                        name: 'house_number',
                        type: 'text',
                        className: 'col-auto',
                        placeholder: '',
                        label: 'pages.customers.form.house_number',
                    },
                ]},
                { className: "flex gap-4",
                fields : [
                    {
                        name: 'zip_code',
                        type: 'text',
                        className: 'w-full',
                        placeholder: '',
                        label: 'pages.customers.form.zip_code',
                    },
                    {
                        name: 'city',
                        type: 'text',
                        className: 'w-full',
                        placeholder: '',
                        label: 'pages.customers.form.city',
                    },
                ]},
                { className: "flex gap-4",
                fields : [
                    {
                        subfield: 'country_name',
                        name: 'country',
                        type: 'text',
                        className: 'w-full',
                        placeholder: '',
                        label: 'pages.customers.form.country',
                    }
                ]},
                { className: "flex gap-4 mt-2 border-t pt-8",
                fields : [
                    {
                        name: 'phone',
                        type: 'text',
                        className: 'w-full',
                        placeholder: '',
                        label: 'pages.customers.form.phone',
                    },
                ]},
                { className: "flex gap-4",
                fields : [
                    {
                        name: 'email',
                        type: 'text',
                        className: 'w-full',
                        placeholder: '',
                        label: 'pages.customers.form.email',
                    },
                ]},
            ],
        },
    }   
}

