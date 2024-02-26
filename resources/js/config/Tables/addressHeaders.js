const headers = [
    { 
        show: false, 
        key: "id",
        contentConfig: {
            type: 'link',
            use: "id",
            to: 'addresses.edit'
        },
        title: "tables.addresses.headers.id", 
        sortable: true, 
        filterable: true, 
        searchable: false, 
        search_key: 'id'
    },
    { 
        show: false, 
        key: "customer_id", 
        title: "tables.addresses.headers.customer_id", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'customer_id'
    },
    { 
        show: false, 
        key: "forwarder_id", 
        title: "tables.addresses.headers.forwarder_id", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'forwarder_id'
    },
    { 
        show: false, 
        key: "country_id", 
        title: "tables.addresses.headers.country_id", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'country_id'
    },
    { 
        show: false, 
        key: "partner_id", 
        title: "tables.addresses.headers.partner_id", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'partner_id'
    },
    { 
        show: true, 
        key: "company_name", 
        contentConfig: {
            type: 'link',
            use: "id",
            to: 'addresses.edit'
        },
        title: "tables.addresses.headers.company_name", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'company_name'
    },
    { 
        show: true, 
        key: "first_name", 
        title: "tables.addresses.headers.first_name", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'first_name'
    },
    { 
        show: true, 
        key: "last_name", 
        title: "tables.addresses.headers.last_name", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'last_name'
    },
    { 
        show: true, 
        key: "street", 
        title: "tables.addresses.headers.street", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'street'
    },
    { 
        show: true, 
        key: "house_number", 
        title: "tables.addresses.headers.house_number", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'house_number'
    },
    { 
        show: true, 
        key: "zip_code", 
        title: "tables.addresses.headers.zip_code", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'zip_code'
    },
    { 
        show: true, 
        key: "city", 
        title: "tables.addresses.headers.city", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'city'
    },
    { 
        show: false, 
        key: "state", 
        title: "tables.addresses.headers.state", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'state'
    },
    { 
        show: false, 
        key: "address_additional_information", 
        title: "tables.addresses.headers.address_additional_information", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'address_additional_information'
    },
    { 
        show: false, 
        key: "phone", 
        title: "tables.addresses.headers.phone", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'phone'
    },
    { 
        show: false, 
        key: "email", 
        title: "tables.addresses.headers.email", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'email'
    },
    { 
        show: false, 
        key: "is_pickup", 
        title: "tables.addresses.headers.is_pickup", 
        sortable: true, 
        filterable: true, 
        searchable: false, 
        search_key: 'is_pickup'
    },
    { 
        show: false, 
        key: "is_delivery", 
        title: "tables.addresses.headers.is_delivery", 
        sortable: true, 
        filterable: true, 
        searchable: false, 
        search_key: 'is_delivery'
    },
    { 
        show: false, 
        key: "is_billing", 
        title: "tables.addresses.headers.is_billing", 
        sortable: true, 
        filterable: true, 
        searchable: false, 
        search_key: 'is_billing'
    },
    { 
        show: false, 
        key: "is_headquarter", 
        title: "tables.addresses.headers.is_headquarter", 
        sortable: true, 
        filterable: true, 
        searchable: false, 
        search_key: 'is_headquarter'
    },
    { 
        show: false, 
        key: "created_at", 
        title: "tables.addresses.headers.created_at", 
        sortable: true, 
        filterable: true, 
        searchable: false, 
        search_key: 'created_at'
    },
    { 
        show: false, 
        key: "updated_at", 
        title: "tables.addresses.headers.updated_at", 
        sortable: true, 
        filterable: true, 
        searchable: true, 
        search_key: 'updated_at'
    }
];


export default headers;