export default [
    { 
        section: 'filter-labels.order',
        relation: false,
        fields: [
            { name: 'order_number', label: 'labels.order_number', type: 'text' },
            { name: 'customer_reference', label: 'labels.customer_reference', type: 'text' },
            { name: 'order_status', label: 'labels.order_status', type: 'select', options: ['Pending', 'Processing', 'Completed', 'Cancelled'] },
            { name: 'payment_status', label: 'labels.payment_status', type: 'select', options: ['Pending', 'Processing', 'Completed', 'Cancelled'] },
            { name: 'payment_method', label: 'labels.payment_method', type: 'select', options: ['Cash', 'Bank Transfer', 'Credit Card'] },
            { name: 'order_date', label: 'labels.order_date', type: 'date' },
            { name: 'delivery_date', label: 'labels.delivery_date', type: 'date' },
        ]
    },
    // {
    //     section: 'filter-labels.customer',
    //     relation: 'customerAddresses',
    //     fields: [
    //         { name: 'internal_id', label: 'labels.internal_id', type: 'text' },
    //         { name: 'email', label: 'labels.email', type: 'text' },
    //         { name: 'company_name', label: 'labels.company', type: 'text' },
    //         { name: 'first_name', label: 'labels.first_name', type: 'text' },
    //         { name: 'last_name', label: 'labels.last_name', type: 'text' },
    //         { name: 'zip_code', label: 'labels.zipcode', type: 'text' },
    //         { name: 'city', label: 'labels.city', type: 'text' },
    //     ]
    // },
    {
        section: 'filter-labels.pickup',
        relation: 'pickupAddresses',
        fields: [
            { name: 'company_name', label: 'labels.company_name', type: 'text' },
            { name: 'first_name', label: 'labels.first_name', type: 'text' },
            { name: 'last_name', label: 'labels.last_name', type: 'text' },
            { name: 'zip_code', label: 'labels.zipcode', type: 'text' },
            { name: 'city', label: 'labels.city', type: 'text' },
            { name: 'country', label: 'labels.country', type: 'text' },
        ]
    }
    ,{
        section: 'filter-labels.delivery',
        relation: 'deliveryAddresses',
        fields: [
            { name: 'company_name', label: 'labels.company_name', type: 'text' },
            { name: 'first_name', label: 'labels.first_name', type: 'text' },
            { name: 'last_name', label: 'labels.last_name', type: 'text' },
            { name: 'zip_code', label: 'labels.zipcode', type: 'text' },
            { name: 'city', label: 'labels.city', type: 'text' },
            { name: 'country', label: 'labels.country', type: 'text' },
        ]
    }
]