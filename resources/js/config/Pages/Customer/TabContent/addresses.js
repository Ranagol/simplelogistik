export default {
    title: "forms.customers.addresses",
    preset: "table",
    contentLoader: {
        create: {
            load: false
        },
        edit: {
            load: true,
            resource: 'customers.addresses',
        },
    },
}

