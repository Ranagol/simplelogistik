export default [
    { 
        section: 'label.general',
        relation: false,
        fields: [
            { name: 'order_id', label: 'labels.order_id', type: 'text' },
            { name: 'customer_name', label: 'labels.customer_name', type: 'text' },
            { name: 'order_status', label: 'labels.order_status', type: 'select', options: ['Pending', 'Processing', 'Completed', 'Cancelled'] },
            { name: 'payment_status', label: 'labels.payment_status', type: 'select', options: ['Pending', 'Processing', 'Completed', 'Cancelled'] },
            { name: 'payment_method', label: 'labels.payment_method', type: 'select', options: ['Cash', 'Bank Transfer', 'Credit Card'] },
            { name: 'order_date', label: 'labels.order_date', type: 'date' },
            { name: 'delivery_date', label: 'labels.delivery_date', type: 'date' },
        ]
    },
    {
        section: 'labels.customer',
        relation: 'customer',
        fields: [
            { name: 'internal_id', label: 'labels.internal_id', type: 'text' },
            { name: 'email', label: 'labels.email', type: 'text' },
            { name: 'company_name', label: 'labels.company', type: 'text' },
            { name: 'first_name', label: 'labels.first_name', type: 'text' },
            { name: 'last_name', label: 'labels.last_name', type: 'text' },
            { name: 'zipcode', label: 'labels.zipcode', type: 'text' },
            { name: 'city', label: 'labels.city', type: 'text' },
        ]
    }
    ,{
        section: 'filter-labels.pickup',
        relation: 'pickupAddresses',
        fields: [
            { name: 'company_name', label: 'labels.company_name', type: 'text' },
            { name: 'first_name', label: 'labels.first_name', type: 'text' },
            { name: 'last_name', label: 'labels.last_name', type: 'text' },
            { name: 'zipcode', label: 'labels.zipcode', type: 'text' },
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
            { name: 'zipcode', label: 'labels.zipcode', type: 'text' },
            { name: 'city', label: 'labels.city', type: 'text' },
            { name: 'country', label: 'labels.country', type: 'text' },
        ]
    }
]