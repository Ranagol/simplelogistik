export default {
    columns: [
        {
            className: 'col-span-3',
            sections: [
                {
                    title: "pages.orders.form.sections.order_details",
                    sectionType: "default",
                    collapsible: true,
                    rows: [
                        {
                            className: 'grid grid-flow-row grid-cols-2 gap-4',
                            fields: [
                                {
                                    name: 'type_of_transport',
                                    className: 'col-auto',
                                    placeholder: 'pages.orders.form.type_of_transport',
                                    label: 'pages.orders.form.type_of_transport',
                                    type: 'text',
                                },
                                {
                                    name: 'order_status_id',
                                    type: 'select',
                                    options: "orderstatuses",
                                    displayKey: 'internal_name',
                                    match: "id",
                                    className: 'col-auto',
                                    placeholder: 'pages.orders.form.order_status',
                                    label: 'pages.orders.form.order_status',
                                },
                            ]
                        },
                        {
                            className: 'grid grid-flow-row grid-cols-4 gap-4',
                            fields: [
                                {
                                    name: 'id',
                                    subfield: 'partner',
                                    className: 'col-auto',
                                    type: 'select',
                                    options: "partners",
                                    displayKey: 'company_name',
                                    match: "id",
                                    placeholder: 'pages.orders.form.partner',
                                    label: 'pages.orders.form.partner',
                                },
                                {
                                    name: 'origin',
                                    className: 'col-auto',
                                    type: 'select',
                                    options: "origins",
                                    displayKey: 'title',
                                    match: 'id',
                                    placeholder: 'pages.orders.form.origin',
                                    label: 'pages.orders.form.origin',
                                },
                                {
                                    name: 'customer_reference',
                                    className: 'col-auto',
                                    type: 'text',
                                    placeholder: 'pages.orders.form.customer_refernce',
                                    label: 'pages.orders.form.customer_refernce',
                                },
                                {
                                    name: "details",
                                    subfield: 'distance_km',
                                    className: 'col-auto',
                                    type: 'text',
                                    placeholder: 'pages.orders.form.distance_km',
                                    label: 'pages.orders.form.distance_km',
                                },
                            ]
                        },
                        {
                            className: 'grid-flow-row gap-4',
                            fields: [
                                {
                                    name: 'duration_minutes',
                                    className: 'col-auto',
                                    type: 'text',
                                    placeholder: 'pages.orders.form.duration_minutes',
                                    label: 'pages.orders.form.duration_minutes',
                                },
                                {
                                    name: 'calculation_model_name',
                                    className: 'col-auto',
                                    type: 'text',
                                    placeholder: 'pages.orders.form.calculation_model_name',
                                    label: 'pages.orders.form.calculation_model_name',
                                },
                            ]
                        },
                        {
                            className: 'grid-flow-row gap-4',
                            fields: [
                                {
                                    name: 'particularities',
                                    className: 'col-auto',
                                    type: 'text',
                                    placeholder: 'pages.orders.form.particularities',
                                    label: 'pages.orders.form.particularities',
                                },
                                {
                                    name: 'description_of_transport',
                                    className: 'col-auto',
                                    type: 'text',
                                    placeholder: 'pages.orders.form.description_of_transport',
                                    label: 'pages.orders.form.description_of_transport',
                                }
                            ]
                        },
                    ]
                },
                {
                    title: "pages.orders.form.sections.parcels",
                    sectionType: "parcelEditor",
                    collapsible: true,
                    data: "parcels",
                    fields: [
                        {
                            name: 'length',
                            type: 'text',
                            keyName: 'id',
                            className: 'col-auto',
                            placeholder: 'pages.orders.form.length',
                            label: 'pages.orders.form.length',
                        },
                        {
                            name: 'width',
                            type: 'text',
                            className: 'col-auto',
                            placeholder: 'pages.orders.form.width',
                            label: 'pages.orders.form.width',
                        },
                        {
                            name: 'height',
                            type: 'text',
                            className: 'col-auto',
                            placeholder: 'pages.orders.form.height',
                            label: 'pages.orders.form.height',
                        },
                        {
                            name: 'weight',
                            type: 'text',
                            className: 'col-auto',
                            placeholder: 'pages.orders.form.weight',
                            label: 'pages.orders.form.weight',
                        },
                    ]
                },
                {
                    title: "pages.orders.form.sections.addresses",
                    sectionType: "addressesEditor",
                    collapsible: true,
                    data: "addresses",
                    rows: []
                },
                {
                    title: "pages.orders.form.sections.finances",
                    sectionType: "financialsEditor",
                    collapsible: true,
                    data: "finances",
                    rows: []
                },
                {
                    title: "pages.orders.form.sections.vehicles",
                    sectionType: "vehicleEditor",
                    collapsible: true,
                    data: "vehicles",
                    rows: []
                }
            ]
        },
        {
            className: '',
        }
    ]
}