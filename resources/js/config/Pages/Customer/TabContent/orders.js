export default {
    title: "forms.customers.orders",
    preset: "table",
    contentLoader: {
        create: {
            load: false
        },
        edit: {
            load: true,
            resource: 'customers.orders',
        },
    },
}

