export default {
    sections: [
        {
            "title": "pages.addresses.form.sections.customer_information",
            "rows": [
                {className: 'grid-flow-row gap-4', fields: [
                        {
                            name: 'company_name',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.addresses.form.company_name',
                            label: 'pages.addresses.form.company_name',
                            // iconColor: '',
                            // iconSize: '',
                            // tooltipText: '',
                        }
                    ]
                },
                {className: 'grid-flow-row gap-4', fields: [
                        {
                            name: 'first_name',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.addresses.form.first_name',
                            label: 'pages.addresses.form.first_name',
                        },
                        {
                            name: 'last_name',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.addresses.form.last_name',
                            label: 'pages.addresses.form.last_name',
                        },
                    ]
                },
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: 'street',
                        className: 'col-auto',
                        type: 'text',
                        placeholder: 'pages.addresses.form.street',
                        label: 'pages.addresses.form.street',
                    },
                    {
                        name: 'house_number',
                        className: 'col-auto',
                        type: 'text',
                        placeholder: 'pages.addresses.form.house_number',
                        label: 'pages.addresses.form.house_number',
                    },
                    {
                        name: 'zip_code',
                        className: 'col-auto',
                        type: 'text',
                        placeholder: 'pages.addresses.form.zip_code',
                        label: 'pages.addresses.form.zip_code',
                    },
                    {
                        name: 'city',
                        className: 'col-auto',
                        type: 'text',
                        placeholder: 'pages.addresses.form.city',
                        label: 'pages.addresses.form.city',
                    },
                ]},
                {className: 'grid-flow-row grid-cols-2 gap-4', fields: [
                    {
                        name: 'state',
                        className: 'col-1',
                        type: 'text',
                        placeholder: 'pages.addresses.form.state',
                        label: 'pages.addresses.form.state',
                    },
                    {
                        name: "country_id", 
                        className: 'col-1',
                        label: "pages.addresses.form.country", 
                        placeholder: "pages.addresses.form.country", 
                        type: "select",
                        options: "countries",
                        displayKey: "country_name",
                        match: "id",
                    },
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: 'address_additional_information', 
                        className: 'col-auto',
                        type: 'text',
                        placeholder: 'pages.addresses.form.address_additional_information',
                        label: 'pages.addresses.form.address_additional_information',
                    },
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: 'phone',
                        className: 'col-auto',
                        type: 'text',
                        placeholder: 'pages.addresses.form.phone',
                        label: 'pages.addresses.form.phone',
                    },
                    {
                        name: 'email',
                        className: 'col-auto',
                        type: 'text',
                        placeholder: 'pages.addresses.form.email',
                        label: 'pages.addresses.form.email',
                    },
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        name: 'is_pickup',
                        className: 'col-auto',
                        type: 'check',
                        placeholder: 'pages.addresses.form.is_pickup',
                        label: 'pages.addresses.form.is_pickup',
                    },
                    {
                        name: 'is_delivery',
                        className: 'col-auto',
                        type: 'check',
                        placeholder: 'pages.addresses.form.is_delivery',
                        label: 'pages.addresses.form.is_delivery',
                    },
                    {
                        name: 'is_billing',
                        className: 'col-auto',
                        type: 'check',
                        placeholder: 'pages.addresses.form.is_billing',
                        label: 'pages.addresses.form.is_billing',
                    },
                    {
                        name: 'is_headquarter',
                        className: 'col-auto',
                        type: 'check',
                        placeholder: 'pages.addresses.form.is_headquarter',
                        label: 'pages.addresses.form.is_headquarter',
                    },
                ]},
            ]
        }
    ]
}