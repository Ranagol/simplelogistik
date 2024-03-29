const headers = [
    {
        show: false, 
        key: "order_number",
        contentConfig: {
            type: 'link',
            use: "id",
            to: 'orders.edit'
        },
        title: "tables.orders.headers.order_number", 
        sortable: true, 
        filterable: true,
        searchable: true,
        search_key: ''
    },{
        show: false, 
        key: "forwarder", 
        subkey: "company_name",
        title: "tables.orders.headers.forwarder", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: false, 
        key: "type_of_transport", 
        title: "tables.orders.headers.type_of_transport", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: false, 
        key: "origin", 
        title: "tables.orders.headers.origin", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: false, 
        key: "status", 
        title: "tables.orders.headers.status", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: false, 
        key: "customer_reference", 
        title: "tables.orders.headers.customer_reference", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: false, 
        key: "provision", 
        title: "tables.orders.headers.provision", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },
    {
        show: false, 
        key: "currency", 
        title: "tables.orders.headers.currency", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: true, 
        key: "order_date", 
        title: "tables.orders.headers.order_date", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: false, 
        key: "purchase_price", 
        title: "tables.orders.headers.purchase_price", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: true, 
        key: "month_and_year", 
        title: "tables.orders.headers.month_and_year", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: true, 
        key: "created_at", 
        title: "tables.orders.headers.created_at", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: true, 
        key: "updated_at", 
        title: "tables.orders.headers.updated_at", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: false, 
        key: "payment_method", 
        title: "tables.orders.headers.payment_method", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: false, 
        key: "easy_bill_customer_id", 
        title: "tables.orders.headers.easy_bill_customer_id", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: false, 
        key: "last_update", 
        title: "tables.orders.headers.last_update", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: false, 
        key: "last_editor", 
        title: "tables.orders.headers.last_editor", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    }
];


export default headers;