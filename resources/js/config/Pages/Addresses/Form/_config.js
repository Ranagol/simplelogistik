export default {
    sections: [
        {
            "title": "pages.addresses.form.sections.customer_information",
            "fields": [
                {
                    name: 'company_name',
                    size: 'col-span-6',
                    type: 'text',
                    placeholder: 'pages.addresses.form.company_name',
                    label: 'pages.addresses.form.company_name',
                    // iconColor: '',
                    // iconSize: '',
                    // tooltipText: '',
                },
                {
                    name: 'first_name',
                    size: 'col-span-6',
                    type: 'text',
                    placeholder: 'pages.addresses.form.first_name',
                    label: 'pages.addresses.form.first_name',
                },
                {
                    name: 'last_name',
                    size: 'col-span-6',
                    type: 'text',
                    placeholder: 'pages.addresses.form.last_name',
                    label: 'pages.addresses.form.last_name',
                },
                {
                    name: 'street',
                    size: 'col-span-6',
                    type: 'text',
                    placeholder: 'pages.addresses.form.street',
                    label: 'pages.addresses.form.street',
                },
                {
                    name: 'house_number',
                    size: 'col-span-6',
                    type: 'text',
                    placeholder: 'pages.addresses.form.house_number',
                    label: 'pages.addresses.form.house_number',
                },
                {
                    name: 'zip_code',
                    size: 'col-span-6',
                    type: 'text',
                    placeholder: 'pages.addresses.form.zip_code',
                    label: 'pages.addresses.form.zip_code',
                },
                {
                    name: 'city',
                    size: 'col-span-6',
                    type: 'text',
                    placeholder: 'pages.addresses.form.city',
                    label: 'pages.addresses.form.city',
                },
                {
                    name: 'state',
                    size: 'col-span-6',
                    type: 'text',
                    placeholder: 'pages.addresses.form.state',
                    label: 'pages.addresses.form.state',
                },
                {
                    "name": "country_id", 
                    "size": "col-span-6",
                    "label": "pages.addresses.form.country", 
                    "placeholder": "pages.addresses.form.country", 
                    "type": "select",
                    "options": "countries",
                    "displayKey": "country_name",
                    "match": "id",
                },
                {
                    name: 'address_additional_information', 
                    size: 'col-span-6',
                    type: 'text',
                    placeholder: 'pages.addresses.form.address_additional_information',
                    label: 'pages.addresses.form.address_additional_information',
                },
                {
                    name: 'phone',
                    size: 'col-span-6',
                    type: 'text',
                    placeholder: 'pages.addresses.form.phone',
                    label: 'pages.addresses.form.phone',
                },
                {
                    name: 'email',
                    size: 'col-span-6',
                    type: 'text',
                    placeholder: 'pages.addresses.form.email',
                    label: 'pages.addresses.form.email',
                },
                {
                    name: 'is_pickup',
                    size: 'col-span-6',
                    type: 'check',
                    placeholder: 'pages.addresses.form.is_pickup',
                    label: 'pages.addresses.form.is_pickup',
                },
                {
                    name: 'is_delivery',
                    size: 'col-span-6',
                    type: 'check',
                    placeholder: 'pages.addresses.form.is_delivery',
                    label: 'pages.addresses.form.is_delivery',
                },
                {
                    name: 'is_billing',
                    size: 'col-span-6',
                    type: 'check',
                    placeholder: 'pages.addresses.form.is_billing',
                    label: 'pages.addresses.form.is_billing',
                },
                {
                    name: 'is_headquarter',
                    size: 'col-span-6',
                    type: 'check',
                    placeholder: 'pages.addresses.form.is_headquarter',
                    label: 'pages.addresses.form.is_headquarter',
                },
            ]
        }
        
    ]
}

