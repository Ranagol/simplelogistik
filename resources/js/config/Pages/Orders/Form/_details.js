export default {
<<<<<<< HEAD
=======
    columns: [
        {
            className: 'col-span-3',
            
        },
        {
            className: '',
        }
    ],
>>>>>>> main
    sections: [
        {
            title: "pages.orders.form.sections.order_details",
            sectionType: "default",
            collapsible: true,
            rows: [
                {
<<<<<<< HEAD
                    className: 'grid-flow-row gap-4',
                    fields: [
                        {
                            name: 'type_of_transport',
                            type: 'text',
                            keyName: 'id',
                            className: 'col-auto',
                            placeholder: 'pages.orders.form.type_of_transport',
                            label: 'pages.orders.form.type_of_transport',
                        },
                        {
                            name: 'order_status_id',
                            type: 'text',
=======
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
>>>>>>> main
                            className: 'col-auto',
                            placeholder: 'pages.orders.form.order_status',
                            label: 'pages.orders.form.order_status',
                        },
                    ]
                },
                {
<<<<<<< HEAD
                    className: 'grid-flow-row gap-4',
                    fields: [
                        {
                            name: 'partner',
                            className: 'col-auto',
                            type: 'text',
=======
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
>>>>>>> main
                            placeholder: 'pages.orders.form.partner',
                            label: 'pages.orders.form.partner',
                        },
                        {
                            name: 'origin',
                            className: 'col-auto',
<<<<<<< HEAD
                            type: 'text',
=======
                            type: 'select',
                            options: "origins",
                            displayKey: 'title',
                            match: 'id',
>>>>>>> main
                            placeholder: 'pages.orders.form.origin',
                            label: 'pages.orders.form.origin',
                        },
                        {
<<<<<<< HEAD
                            name: 'type_of_transport',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.orders.form.first_name',
                            label: 'pages.orders.form.first_name',
                        },
                        {
                            name: 'type_of_transport',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.orders.form.first_name',
                            label: 'pages.orders.form.first_name',
=======
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
>>>>>>> main
                        },
                    ]
                },
                {
                    className: 'grid-flow-row gap-4',
                    fields: [
                        {
<<<<<<< HEAD
                            name: 'type_of_transport',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.orders.form.first_name',
                            label: 'pages.orders.form.first_name',
                        },
                        {
                            name: 'type_of_transport',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.orders.form.first_name',
                            label: 'pages.orders.form.first_name',
=======
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
>>>>>>> main
                        },
                    ]
                },
                {
                    className: 'grid-flow-row gap-4',
                    fields: [
                        {
<<<<<<< HEAD
                            name: 'type_of_transport',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.orders.form.first_name',
                            label: 'pages.orders.form.first_name',
                        },
                        {
                            name: 'type_of_transport',
                            className: 'col-auto',
                            type: 'text',
                            placeholder: 'pages.orders.form.first_name',
                            label: 'pages.orders.form.first_name',
=======
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
>>>>>>> main
                        }
                    ]
                },
            ]
        },
        {
            title: "pages.orders.form.sections.parcels",
<<<<<<< HEAD
            sectionType: "parcel",
            collapsible: true,
            data: "parcels",
            rows: [
                {
                    className: 'grid-flow-row gap-4',
                    fields: [
                        {
                            name: 'parcel_type',
                            type: 'select',
                            keyName: 'id',
                            className: 'col-auto min-w-48 w-48',
                            placeholder: 'pages.orders.form.parcel_type',
                            label: 'pages.orders.form.parcel_type',
                        },
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
                }
            ]
        },
        {
            title: "pages.orders.form.sections.orders",
            sectionType: "default",
            collapsible: true,
=======
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
>>>>>>> main
            rows: []
        },
        {
            title: "pages.orders.form.sections.finances",
<<<<<<< HEAD
            sectionType: "default",
            collapsible: true,
=======
            sectionType: "financialsEditor",
            collapsible: true,
            data: "finances",
>>>>>>> main
            rows: []
        },
        {
            title: "pages.orders.form.sections.vehicles",
<<<<<<< HEAD
            sectionType: "default",
            collapsible: true,
            rows: []
        }
    ]
}
=======
            sectionType: "vehicleEditor",
            collapsible: true,
            data: "vehicles",
            rows: []
        }
    ]
}

>>>>>>> main
