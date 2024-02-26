export default {
    section: true,
    sectionConfig: 'simple_grid',
    sectionID: 'orderInformation',
    sectionTitle: 'forms.orderForm.sections.orderInformation',
    fields: [
        {
            editable: {
                edit: true,
                create: true,
            },
            name: 'type_of_transport',
            type: 'dropdown',
            label: 'forms.orderForm.fields.orderType',
            placeholder: 'forms.orderForm.fields.orderType',
            options: 'shippingTypes',
            hint: 'forms.orderForm.fields.orderTypeHint',
            class: 'col-span-6',
        },
    ]
}