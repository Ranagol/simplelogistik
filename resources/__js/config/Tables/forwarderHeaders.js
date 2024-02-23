const headers = [
    {
        show: true,
        key: "id",
        contentConfig: {
            type: 'link',
            use: "id",
            to: 'forwarders.edit'
        },
        searchable: true,
        search_key: 'id',
        filterable: true,
        title: "tables.forwarders.headers.id"
    },
    {
        show: true,
        key: "company_name",
        searchable: true,
        search_key: 'company_name',
        filterable: true,
        title: "tables.forwarders.headers.company_name"
    },
    {
        show: false,
        key: "internal_id",
        searchable: true,
        search_key: 'internal_id',
        filterable: true,
        title: "tables.forwarders.headers.internal_id"
    },
    {
        show: true,
        key: "name",
        searchable: true,
        search_key: 'name',
        filterable: true,
        title: "tables.forwarders.headers.name"
    },
    {
        show: true,
        key: "email",
        searchable: true,
        search_key: 'email',
        filterable: true,
        title: "tables.forwarders.headers.email"
    },
    {
        show: true,
        key: "tax_number",
        searchable: true,
        search_key: 'tax_number',
        filterable: true,
        title: "tables.forwarders.headers.tax_number"
    },
    {
        show: true,
        key: "rating",
        searchable: true,
        search_key: 'rating',
        filterable: true,
        title: "tables.forwarders.headers.rating"
    },
    {
        show: true,
        key: "forwarder_type",
        searchable: true,
        search_key: 'forwarder_type',
        filterable: true,
        title: "tables.forwarders.headers.forwarder_type"
    },
    {
        show: false,
        key: "comments",
        searchable: true,
        search_key: 'comments',
        filterable: true,
        title: "tables.forwarders.headers.comments"
    },
    {
        show: false,
        key: "url_logo",
        searchable: true,
        search_key: 'url_logo',
        filterable: true,
        title: "tables.forwarders.headers.url_logo"
    },
    {
        show: false,
        key: "created_at",
        searchable: true,
        search_key: 'created_at',
        filterable: true,
        title: "tables.forwarders.headers.created_at"
    },
    {
        show: false,
        key: "updated_at",
        searchable: true,
        search_key: 'updated_at',
        filterable: true,
        title: "tables.forwarders.headers.updated_at"
    },
];


export default headers;