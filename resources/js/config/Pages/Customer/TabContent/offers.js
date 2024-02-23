export default {
    title: "forms.customers.offers",
    preset: "table",
    contentLoader: {
        create: {
            load: false
        },
        edit: {
            load: true,
            resource: 'customers.offers',
        },
    },
}