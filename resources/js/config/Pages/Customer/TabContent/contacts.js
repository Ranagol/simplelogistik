export default {
    title: "forms.customers.contacts",
    preset: "table",
    contentLoader: {
        create: {
            load: false
        },
        edit: {
            load: true,
            resource: 'customers.contacts',
        },
    },
}