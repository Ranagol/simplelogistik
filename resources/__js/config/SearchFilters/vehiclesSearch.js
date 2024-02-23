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
    }
]