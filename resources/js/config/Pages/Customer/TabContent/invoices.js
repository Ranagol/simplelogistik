export default {
    title: "forms.customers.invoices",
    preset: "table",
    contentLoader: {
        create: {
            load: false
        },
        edit: {
            load: true,
            resource: 'customers.invoices',
        },
    },
}