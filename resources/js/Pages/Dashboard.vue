<template>
    <Head title="Dashboard" />
    <TableWithContent />
    <TableWithActions :data="dummyEntries" :headers="headers" :actions="['show', 'delete']" />
</template>

<script setup>
import TableWithActions from '@/Components/Tables/TableWithActions.vue';
import TableWithContent from '@/Components/Tables/TableWithContent.vue';

const headers = [
    {
        text: 'ID',
        key: 'id',
        filterable: false,
        searchable: false,
        orderable: true
    },
    {
        text: 'Name',
        key: 'name',
        filterable: false,
        searchable: true,
        orderable: false
    },
    {
        text: 'Address',
        key: 'address',
        filterable: false,
        searchable: false,
        orderable: true
    },
    {
        text: 'Postal Code',
        key: 'postal_code',
        filterable: false,
        searchable: true,
        orderable: false
    },
    {
        text: 'City',
        key: 'city',
        filterable: false,
        searchable: true,
        orderable: false
    },
    {
        text: 'Country',
        key: 'country',
        filterable: false,
        searchable: true,
        orderable: true
    },
    {
        text: 'Payment Method',
        key: 'paymentMethod',
        filterable: false,
        searchable: false,
        orderable: true
    },
    {
        text: 'Amount',
        key: 'amount',
        filterable: false,
        searchable: false,
        orderable: true
    },
    {
        text: 'Status',
        key: 'status',
        filterable: false,
        searchable: false,
        orderable: true
    }
];

const dummyEntries = [
    {
        id: 1,
        name: 'John Doe',
        address: '123 Main St.',
        postal_code: '12345',
        city: 'New York',
        country: 'USA',
        paymentMethod: 'Credit Card',
        amount: 100.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-01-01',
        time: '12:00:00'
    },
    {
        id: 2,
        name: 'Jane Smith',
        address: '456 Elm St.',
        postal_code: '67890',
        city: 'Los Angeles',
        country: 'USA',
        paymentMethod: 'PayPal',
        amount: 50.00,
        status: 'Pending',
        statusCode: 2,
        date: '2021-02-01',
        time: '14:30:00'
    },
    // Add more entries here...
    {
        id: 3,
        name: 'Alice Johnson',
        address: '789 Oak St.',
        postal_code: '54321',
        city: 'Chicago',
        country: 'USA',
        paymentMethod: 'Bank Transfer',
        amount: 75.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-05-01',
        time: '09:45:00'
    },
    {
        id: 4,
        name: 'Bob Williams',
        address: '321 Pine St.',
        postal_code: '98765',
        city: 'San Francisco',
        country: 'USA',
        paymentMethod: 'Cash',
        amount: 200.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-06-01',
        time: '16:00:00'
    },
    {
        id: 5,
        name: 'Michael Johnson',
        address: '789 Oak St.',
        postal_code: '54321',
        city: 'Chicago',
        country: 'USA',
        paymentMethod: 'Bank Transfer',
        amount: 75.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-05-01',
        time: '09:45:00'
    },
    {
        id: 6,
        name: 'John Doe',
        address: '123 Main St.',
        postal_code: '12345',
        city: 'New York',
        country: 'USA',
        paymentMethod: 'Credit Card',
        amount: 100.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-01-01',
        time: '12:00:00'
    },
    {
        id: 7,
        name: 'Jane Smith',
        address: '456 Elm St.',
        postal_code: '67890',
        city: 'Los Angeles',
        country: 'USA',
        paymentMethod: 'PayPal',
        amount: 50.00,
        status: 'Pending',
        statusCode: 2,
        date: '2021-02-01',
        time: '14:30:00'
    },
    {
        id: 8,
        name: 'Alice Johnson',
        address: '789 Oak St.',
        postal_code: '54321',
        city: 'Chicago',
        country: 'USA',
        paymentMethod: 'Bank Transfer',
        amount: 75.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-05-01',
        time: '09:45:00'
    },
    {
        id: 9,
        name: 'Bob Williams',
        address: '321 Pine St.',
        postal_code: '98765',
        city: 'San Francisco',
        country: 'USA',
        paymentMethod: 'Cash',
        amount: 200.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-06-01',
        time: '16:00:00'
    },
    {
        id: 20,
        name: 'Michael Johnson',
        address: '789 Oak St.',
        postal_code: '54321',
        city: 'Chicago',
        country: 'USA',
        paymentMethod: 'Bank Transfer',
        amount: 75.00,
        status: 'Paid',
        statusCode: 8,
        date: '2021-05-01',
        time: '09:45:00'
    }
];
</script>


<style>
</style>


