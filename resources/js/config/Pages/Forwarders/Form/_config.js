export default {
    sections: [
        {
            title: "pages.forwarders.form.sections.customer_information",
            cols: 12,
            rows: [
<<<<<<< HEAD
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        "name": "company_name",
                        "className": "col-auto",
                        "label": "pages.forwarders.form.company_name",
                        "placeholder": "pages.forwarders.form.company_name",
                        "type": "text"
                    },
                    {
                        "name": "internal_id",
                        "className": "col-auto",
                        "label": "pages.forwarders.form.internal_id",
                        "placeholder": "pages.forwarders.form.internal_id",
                        "type": "text"
                    },
                ]},
                {className: 'grid-flow-row gap-4', fields: [
                    {
                        "name": "name",
                        "className": "col-auto",
                        "label": "pages.forwarders.form.name",
                        "placeholder": "pages.forwarders.form.name",
                        "type": "text"
                    },
                    {
                        "name": "email",
                        "className": "col-auto",
                        "label": "pages.forwarders.form.email",
                        "placeholder": "pages.forwarders.form.email",
                        "type": "text"
                    },
                ]},
                {className: 'grid-flow-row gap-4', fields: [
=======
                {
                    className: 'grid grid-flow-row grid-cols-2 gap-4',
                    fields: [
                        {
                            "name": "company_name",
                            "className": "col-auto",
                            "label": "pages.forwarders.form.company_name",
                            "placeholder": "pages.forwarders.form.company_name",
                            "type": "text"
                        },
                        {
                            "name": "internal_id",
                            "className": "col-auto",
                            "label": "pages.forwarders.form.internal_id",
                            "placeholder": "pages.forwarders.form.internal_id",
                            "type": "text"
                        },
                    ]
                },
                {
                    className: 'grid grid-flow-row grid-cols-2 gap-4',
                    fields: [
                        {
                            "name": "name",
                            "className": "col-auto",
                            "label": "pages.forwarders.form.name",
                            "placeholder": "pages.forwarders.form.name",
                            "type": "text"
                        },
                        {
                            "name": "email",
                            "className": "col-auto",
                            "label": "pages.forwarders.form.email",
                            "placeholder": "pages.forwarders.form.email",
                            "type": "text"
                        },
                    ]
                },
                {
                    className: 'grid grid-flow-row grid-cols-1 gap-4',
                    fields: [
>>>>>>> main
                    {
                        "name": "tax_number",
                        "className": "col-auto",
                        "label": "pages.forwarders.form.tax_number",
                        "placeholder": "pages.forwarders.form.tax_number",
                        "type": "text"
                    },
                ]},
<<<<<<< HEAD
                {className: 'grid-flow-row gap-4', fields: [
=======
                {
                    className: 'grid grid-flow-row grid-cols-2 gap-4',
                    fields: [
>>>>>>> main
                    {
                        "name": "rating",
                        "className": "col-auto",
                        "label": "pages.forwarders.form.rating",
                        "placeholder": "pages.forwarders.form.rating",
                        "type": "select",
                        "options": "ratings",
                        "match": "rating",
<<<<<<< HEAD
                        "displayKey": "rating|translate:title",
=======
                        "displayKey": "title",
>>>>>>> main
                    },
                    {
                        "name": "forwarder_type",
                        "className": "col-auto",
                        "label": "pages.forwarders.form.forwarder_type",
                        "placeholder": "pages.forwarders.form.forwarder_type",
                        "type": "text"
                    },
                ]},
<<<<<<< HEAD
                {className: 'grid-flow-row gap-4', fields: [
=======
                {className: 'grid grid-flow-row grid-cols-2 gap-4', fields: [
>>>>>>> main
                    {
                        "name": "comments",
                        "className": "col-auto",
                        "label": "pages.forwarders.form.comments",
                        "placeholder": "pages.forwarders.form.comments",
                        "type": "text"
                    },
                    {
                        "name": "url_logo",
                        "className": "col-auto",
                        "label": "pages.forwarders.form.url_logo",
                        "placeholder": "pages.forwarders.form.url_logo",
                        "type": "text"
                    }
                ]}
            ]
        }
        
    ]
}