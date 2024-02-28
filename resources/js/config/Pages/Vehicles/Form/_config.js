export default {
    sections: [
        {
            title: "pages.vehicles.form.sections.customer_information",
            cols: 12,
            rows: [
                {
                    className: 'grid grid-flow-row grid-cols-4 gap-4',
                    fields: [
                        {
                            "name": "max_pickup_weight",
                            "className": "col-auto",
                            "label": "pages.vehicles.form.max_pickup_weight",
                            "placeholder": "pages.vehicles.form.max_pickup_weight",
                            "type": "text"
                        },
                        {
                            "name": "max_pickup_width",
                            "className": "col-auto",
                            "label": "pages.vehicles.form.max_pickup_width",
                            "placeholder": "pages.vehicles.form.max_pickup_width",
                            "type": "text"
                        },
                        {
                            "name": "max_pickup_height",
                            "className": "col-auto",
                            "label": "pages.vehicles.form.max_pickup_height",
                            "placeholder": "pages.vehicles.form.max_pickup_height",
                            "type": "text"
                        },
                        {
                            "name": "max_pickup_length",
                            "className": "col-auto",
                            "label": "pages.vehicles.form.max_pickup_length",
                            "placeholder": "pages.vehicles.form.max_pickup_length",
                            "type": "text"
                        },
                    ]
                },
                {
                    className: 'grid grid-flow-row grid-cols-1 gap-4',
                    fields: [
                    {
                        "name": "tax_number",
                        "className": "col-auto",
                        "label": "pages.vehicles.form.tax_number",
                        "placeholder": "pages.vehicles.form.tax_number",
                        "type": "text"
                    },
                ]},
                {
                    className: 'grid grid-flow-row grid-cols-2 gap-4',
                    fields: [
                    {
                        "name": "rating",
                        "className": "col-auto",
                        "label": "pages.vehicles.form.rating",
                        "placeholder": "pages.vehicles.form.rating",
                        "type": "select",
                        "options": "ratings",
                        "match": "rating",
                        "displayKey": "title",
                    },
                    {
                        "name": "forwarder_type",
                        "className": "col-auto",
                        "label": "pages.vehicles.form.forwarder_type",
                        "placeholder": "pages.vehicles.form.forwarder_type",
                        "type": "text"
                    },
                ]},
                {className: 'grid grid-flow-row grid-cols-2 gap-4', fields: [
                    {
                        "name": "comments",
                        "className": "col-auto",
                        "label": "pages.vehicles.form.comments",
                        "placeholder": "pages.vehicles.form.comments",
                        "type": "text"
                    },
                    {
                        "name": "url_logo",
                        "className": "col-auto",
                        "label": "pages.vehicles.form.url_logo",
                        "placeholder": "pages.vehicles.form.url_logo",
                        "type": "text"
                    }
                ]}
            ]
        }
        
    ]
}