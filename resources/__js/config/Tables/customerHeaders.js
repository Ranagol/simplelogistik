const headers = [
    {
        show: true,
        key: "internal_id",
        contentConfig: {
            type: 'link',
            use: "id",
            to: 'customers.edit'
        },
        title: 'tables.customers.headers.customer_id',
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: '',
    },
    {
        show: false,
        key: "first_name",
        title: 'tables.customers.headers.first_name',
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: '',
    },
    {
        show: true,
        key: "last_name",
        title: 'tables.customers.headers.last_name',
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: '',
    },
    {
        show: true,
        key: "company_name",
        title: 'tables.customers.headers.company_name',
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: '',
    },
    {
        show: true,
        key: "private_customer",
        title: 'tables.customers.headers.business_customer',
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: '',
    }
]


export default headers;