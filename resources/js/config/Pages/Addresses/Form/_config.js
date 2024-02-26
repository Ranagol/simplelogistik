export default {
    sections: [
        {
            "title": "pages.addresses.form.sections.customer_information",
            "cols": 12,
            "fields": [
                {
                    name: 'company_name',
                    type: 'text',
                    size: 12,
                    placeholder: 'pages.addresses.form.company_name',
                    label: 'pages.addresses.form.company_name',
                    // iconColor: '',
                    // iconSize: '',
                    // tooltipText: '',
                },
                {
                    name: 'first_name',
                    type: 'text',
                    size: 6,
                    placeholder: 'pages.addresses.form.first_name',
                    label: 'pages.addresses.form.first_name',
                },
                {
                    name: 'last_name',
                    type: 'text',
                    size: 6,
                    placeholder: 'pages.addresses.form.last_name',
                    label: 'pages.addresses.form.last_name',
                },
                {
                    name: 'street',
                    type: 'text',
                    size: 4,
                    placeholder: 'pages.addresses.form.street',
                    label: 'pages.addresses.form.street',
                },
                {
                    name: 'house_number',
                    type: 'text',
                    size: 4,
                    placeholder: 'pages.addresses.form.house_number',
                    label: 'pages.addresses.form.house_number',
                },
                {
                    name: 'zip_code',
                    type: 'text',
                    size: 4,
                    placeholder: 'pages.addresses.form.zip_code',
                    label: 'pages.addresses.form.zip_code',
                },
                {
                    name: 'city',
                    type: 'text',
                    size: 4,
                    placeholder: 'pages.addresses.form.city',
                    label: 'pages.addresses.form.city',
                },
                {
                    name: 'state',
                    type: 'text',
                    size: 4,
                    placeholder: 'pages.addresses.form.state',
                    label: 'pages.addresses.form.state',
                },
                {
                    name: 'country_id',
                    type: 'select',
                    keyName: 'id',
                    valueKey: 'country_name',
                    matchingKeyName: 'id',
                    matchingValueKey: 'country_name',
                    options: 'countries',
                    size: 4,
                    placeholder: 'pages.addresses.form.country',
                    label: 'pages.addresses.form.country',
                },
                {
                    name: 'address_additional_information',
                    type: 'text',
                    size: 4,
                    placeholder: 'pages.addresses.form.address_additional_information',
                    label: 'pages.addresses.form.address_additional_information',
                },
                {
                    name: 'phone',
                    type: 'text',
                    size: 4,
                    placeholder: 'pages.addresses.form.phone',
                    label: 'pages.addresses.form.phone',
                },
                {
                    name: 'email',
                    type: 'text',
                    size: 4,
                    placeholder: 'pages.addresses.form.email',
                    label: 'pages.addresses.form.email',
                },
                {
                    name: 'is_pickup',
                    type: 'check',
                    size: 4,
                    placeholder: 'pages.addresses.form.is_pickup',
                    label: 'pages.addresses.form.is_pickup',
                },
                {
                    name: 'is_delivery',
                    type: 'check',
                    size: 4,
                    placeholder: 'pages.addresses.form.is_delivery',
                    label: 'pages.addresses.form.is_delivery',
                },
                {
                    name: 'is_billing',
                    type: 'check',
                    size: 4,
                    placeholder: 'pages.addresses.form.is_billing',
                    label: 'pages.addresses.form.is_billing',
                },
                {
                    name: 'is_headquarter',
                    type: 'check',
                    size: 4,
                    placeholder: 'pages.addresses.form.is_headquarter',
                    label: 'pages.addresses.form.is_headquarter',
                },
            ]
        }
        
    ]
}

