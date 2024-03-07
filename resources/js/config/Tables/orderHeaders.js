const headers = [
    {
        show: true, 
        key: "order_number",
        contentConfig: {
            type: 'link',
            use: "id",
            to: 'orders.edit'
        },
        title: "tables.orders.headers.order", 
        sortable: true, 
        filterable: true,
        searchable: true,
        search_key: ''
    },
    {
        show: true, 
        key: "order_status", 
        title: "tables.orders.headers.status", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },
    {
        show: true, 
        key: "type_of_transport", 
        title: "tables.orders.headers.type_of_transport", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },
    {
        show: true, 
        key: "forwarder", 
        subkey: "url_logo",
        contentConfig: {
            type: 'image',
            use: "url_logo",
        },
        title: "tables.orders.headers.forwarder", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },
    {
        show: true, 
        key: "order_date", 
        contentConfig: {
            type: 'date',
            format: 'DD.MM.YYYY'
        },
        title: "tables.orders.headers.order_date", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },
    {
        show: true, 
        key: "firstPickupDate", 
        contentConfig: {
            type: 'date',
            format: 'DD.MM.YYYY'
        },
        title: "tables.orders.headers.pickup_date", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },

    {
        show: true, 
        key: "firstPickupAddress", 
        title: "tables.orders.headers.pickup_address", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },
    {
        show: true, 
        key: "lastDeliveryDate", 
        contentConfig: {
            type: 'date',
            format: 'DD.MM.YYYY'
        },
        title: "tables.orders.headers.delivery_date", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },
    {
        show: true, 
        key: "firstDeliveryAddress", 
        title: "tables.orders.headers.delivery_address", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },
    {
        show: true, 
        key: "customer_reference", 
        title: "tables.orders.headers.customer_reference", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },
    {
        show: true, 
        key: "origin", 
        title: "tables.orders.headers.origin", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },
    
    {
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
        key: "purchase_price", 
        title: "tables.orders.headers.purchase_price", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },
    {
        show: false, 
        key: "month_and_year", 
        contentConfig: {
            type: 'date',
            format: 'DD.MM.YYYY'
        },
        title: "tables.orders.headers.month_and_year", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: false, 
        key: "created_at", 
        contentConfig: {
            type: 'date',
            format: 'DD.MM.YYYY'
        },
        title: "tables.orders.headers.created_at", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: false, 
        key: "updated_at", 
        contentConfig: {
            type: 'date',
            format: 'DD.MM.YYYY'
        },
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
        show: true, 
        key: "last_update", 
        contentConfig: {
            type: 'date',
            format: 'DD.MM.YYYY HH:mm',
            append: " Uhr"
        },
        title: "tables.orders.headers.last_update", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    },{
        show: true, 
        key: "last_editor", 
        standard: 'System',
        title: "tables.orders.headers.last_editor", 
        sortable: true, 
        filterable: true, 
        searchable: true,
        search_key: ''
    }
];


export default headers;